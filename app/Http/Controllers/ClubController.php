<?php

namespace App\Http\Controllers;

use App\Helpers;
use App\Models\Club;
use App\Models\Country;
use App\Models\Event;
use App\Models\Game_rating;
use App\Models\Photo_gallery;
use App\Models\Rating;
use App\Models\Season;
use App\Models\Table_rating;
use App\Models\Video_gallery;
use App\User;
use Carbon\Carbon;
use Illuminate\Support\Facades\App;
use stdClass;
use App\Models\GlobalRating;
use App\Models\Tournament;

class ClubController extends Controller
{
    // Список клубов
    public function index()
    {
        $clubs = Club::orderBy('title', 'asc')->get();
        $countries = Country::orderBy('id', 'asc')->get();

        return view('clubs', [
            'clubs' => $clubs,
            'countries' => $countries,
        ]);
    }

    // Одиночная клуба
    public function single($slug)
    {
        return redirect()->route('club_about', $slug);
    }

    // О клубе
    public function about($slug)
    {
        $club = Club::findBySlug($slug);
        if(!$club) abort(404);

        $meta_title = $club->meta_title;
        $meta_title_ru = $club->meta_title_ru;
        $meta_description_ru = $club->meta_description_ru;
        $meta_description = $club->meta_description;

        return view('clubs-about', [
            'club' => $club,
            'meta_title' =>              isset($meta_title)?(App::getLocale() == 'ru'?$meta_title_ru:$meta_title):NULL,
            'meta_description' =>        isset($meta_description)?(App::getLocale() == 'ru'?$meta_description_ru:$meta_description):NULL,
            'social_meta_title' =>       isset($meta_title)?(App::getLocale() == 'ru'?$meta_title_ru:$meta_title):NULL,
            'social_meta_description' => isset($meta_description)?(App::getLocale() == 'ru'?$meta_description_ru:$meta_description):NULL,

        ]);
    }

    // Рейтинги клуба
    public function rating($slug)
    {
        $club = Club::findBySlug($slug);

        if(!$club) abort(404);

        if($club->table_ratings and count($club->game_ratings)) {
            $count = app('App\Http\Controllers\TournamentController')->count_points($club);
        }

        $seasons_data = Season::where('club_id', $club->id)->orderBy('end', 'desc')->get();

        // Выводим результат
        $rating_data = array();
        foreach($club->users as $club_user) {
            $gameRating = Game_rating::where('prima_nota', $club_user->id)->first();

            if (isset($gameRating)) {
                $tableRating =  Table_rating::where('id', $gameRating->table_ratings_id)->first();
            }else{
                $tableRating = '';
            }

            $start = null;
            $end = null;
            if(isset($_GET['season'])){
                $season = Season::where('id', $_GET['season'])->first();

                $start = $season->start;
                $end = $season->end;
            }


           $pn = Helpers::getPrimaNota($club_user->id, $start, $end, 'club', null);

            $rating_data['users'][] = array(
                'Player'        => $club_user->name . ' ' . $club_user->last_name,
                'Nickname'      => $club_user->nickname,
                'Game'          => isset($count["total"][$club_user->id]['Game'])        ? $count["total"][$club_user->id]['Game']    : 0,
                'Win'           => isset($count["total"][$club_user->id]['Win'])         ? $count["total"][$club_user->id]['Win']     : 0,
                'WR'            => isset($count["total"][$club_user->id]['WR'])          ? $count["total"][$club_user->id]['WR']      : 0,
                'WB'            => isset($count["total"][$club_user->id]['WB'])          ? $count["total"][$club_user->id]['WB']      : 0,
                'Fail'          => isset($count["total"][$club_user->id]['Fail'])        ? $count["total"][$club_user->id]['Fail']    : 0,
                'Citizen'       => isset($count["total"][$club_user->id]['Citizen'])     ? $count["total"][$club_user->id]['Citizen'] : 0,
                'Mafia'         => isset($count["total"][$club_user->id]['Mafia'])       ? $count["total"][$club_user->id]['Mafia']   : 0,
                'Sheriff'       => isset($count["total"][$club_user->id]['Sheriff'])     ? $count["total"][$club_user->id]['Sheriff'] : 0,
                'Sheriff_Win'   => isset($count["total"][$club_user->id]['Sheriff_Win']) ? $count["total"][$club_user->id]['Sheriff_Win'] : 0,
                'Don'           => isset($count["total"][$club_user->id]['Don'])         ? $count["total"][$club_user->id]['Don']     : 0,
                'Don_Win'       => isset($count["total"][$club_user->id]['Don_Win'])     ? $count["total"][$club_user->id]['Don_Win']     : 0,
                'BM'            => isset($count["total"][$club_user->id]['BM'])          ? $count["total"][$club_user->id]['BM']      : 0,
                'BP'            => isset($count["total"][$club_user->id]['BP'])          ? $count["total"][$club_user->id]['BP']      : 0,
                'Balls'         => isset($count["total"][$club_user->id]['Balls'])       ? round($count["total"][$club_user->id]['Balls'],3)   : 0,
                'PN'            => $pn,
                'Score'         => isset($count["total"][$club_user->id]['Score'])       ? round($count["total"][$club_user->id]['Score'],3)   : 0,
            );
        }


        return view('clubs-rating', [
            'club' => $club,
            'rating_data' => isset($rating_data) ? json_encode($rating_data) : json_encode(array()),
            'seasons' => $seasons_data,
            'eligibel_value' => isset($rating_data) ? $this->eligibelValue($rating_data) : 0
        ]);
    }

    public function allRating() {
        return view('allRating');
    }

    // События клуба
    public function events($slug)
    {
        $club = Club::findBySlug($slug);
        if(!$club) abort(404);

        $events = Event::leftJoin('club_event', 'club_event.event_id', '=', 'events.id')
            ->where('club_event.club_id', '=', $club->id)
            ->whereDate('created_at', '>=', Carbon::now()->format('Y-m-d H:i:s'))
            ->orderBy('id', 'asc')->get();

        return view('clubs-event', [
            'club' => $club,
            'events' => $events,
        ]);
    }

    // Одиночная события
    public function event($slug, $event_slug)
    {
        $club = Club::findBySlug($slug);
        if(!$club) abort(404);
        $event = Event::findBySlug($event_slug);
        if(!$event) abort(404);

        $next_event = Event::orderBy("created_at", 'asc')
            ->leftJoin('club_event', 'club_event.event_id', '=', 'events.id')
            ->where('created_at', '>', $event->created_at)
            ->where('club_event.club_id', '=', $club->id)
            ->first();

        $prev_event = Event::orderBy("created_at", 'desc')
            ->leftJoin('club_event', 'club_event.event_id', '=', 'events.id')
            ->where('created_at', '<', $event->created_at)
            ->where('club_event.club_id', '=', $club->id)
            ->first();

        return view('events-single', [
            'club'          => $club,
            'current_event' => $event,
            'next_event'    => $next_event,
            'prev_event'    => $prev_event,
        ]);
    }

    // Галерея
    public function gallery($slug)
    {
        $club = Club::findBySlug($slug);
        if(!$club) abort(404);
        $PhotoGalleries = Photo_gallery::where('club_id', '=', $club->id)->orderBy('id', 'desc')->paginate(99);
        $VideoGalleries = Video_gallery::where('club_id', '=', $club->id)->orderBy('id', 'desc')->paginate(99);

        return view('clubs-gallery', [
            'club' => $club,
            'PhotoGalleries' => $PhotoGalleries,
            'VideoGalleries' => $VideoGalleries
        ]);
    }

    public function eligibelValue($data) {
        $sort = [];
        for($k = 0; $k < count($data['users']); $k++) {

            $sort[$k] = $data['users'][$k]['Game'];
        }

        rsort($sort);

        $topTen = [];

        for ($i = 0; $i < 10; $i++) {

            if(! isset($sort[$i])) continue;

            $topTen[] = $sort[$i];

        }

        return (int)round(array_sum($topTen)/30);
    }

    public function clubsGlobalRating ($id)
    {
        $clubs = Club::get();

        $global = GlobalRating::find($id);

        if(!$global) abort(404);

        $rating_data = array();
        $start = null;
        $end = null;

        if($global) {
            $start = $global->from_date;
            $end = $global->to_date;
        }

        $tournament = Tournament::where('title', 'like', '%Annual MAF World Cup')->whereYear('created_at', date('Y') )->first();

        $tournamentResult = app('App\Http\Controllers\TournamentController')->count_points($tournament);

        $worldCupUserIds = [];

        $arr = [];

        if(!empty($tournamentResult)) {
        	$worldCupUserIds = array_keys($tournamentResult['total']);

        	foreach ($tournamentResult['total'] as $id => $u) $arr[$id] = $u['Balls'];
        }

        arsort($arr);

        $firstThree = [];
        $i = 0;
        foreach ($arr as $key => $value) {
            if($i == 0) $firstThree[$key] = 0.5;

            if($i == 1) $firstThree[$key] = 0.35;

            if($i == 2) $firstThree[$key] = 0.2;

            $i++;
        }


        $tournamentGames = app('App\Http\Controllers\TournamentController')->globalTournamentRating($start, $end);

        $userIds = array_keys($tournamentGames['users']);

        foreach ($clubs as $club) {

            if ($club->table_ratings and count($club->game_ratings)) {
                $count = app('App\Http\Controllers\TournamentController')->count_points($club, $start, $end);
            }

            if(isset($club->users)) {
                foreach ($club->users as $club_user) {

                    if((isset($count["total"][$club_user->id]['Game']) ? $count["total"][$club_user->id]['Game'] : 0) ) {

                        if(in_array($club_user->id, $userIds)) {

                            $tournamentGamesRating = $tournamentGames['users'][$club_user->id];

                            $pn = Helpers::getPrimaNota($club_user->id, null, null, 'global', null);
                            $data = [];
                            foreach ($tournamentGamesRating as $tournamentRating) {
                                $data['Game'][] = $tournamentRating['Game'];
                                $data['Win'][] = $tournamentRating['Win'];
                                $data['WR'][] = $tournamentRating['WR'];
                                $data['WB'][] = $tournamentRating['WB'];
                                $data['Fail'][] = $tournamentRating['Fail'];
                                $data['Citizen'][] = $tournamentRating['Citizen'];
                                $data['Mafia'][] = $tournamentRating['Mafia'];
                                $data['Sheriff'][] = $tournamentRating['Sheriff'];
                                $data['Sheriff_Win'][] = $tournamentRating['Sheriff_Win'];
                                $data['Don'][] = $tournamentRating['Don'];
                                $data['Don_Win'][] = $tournamentRating['Don_Win'];
                                $data['BM'][] = $tournamentRating['BM'];
                                $data['BP'][] = $tournamentRating['BP'];
                                $data['PN'][] = $pn;
                                $data['Balls'][] = $tournamentRating['Balls'];
                                $data['Score'][] = $tournamentRating['Score'];
                            }

                            $gamesTotal = (isset($count["total"][$club_user->id]['Game']) ? $count["total"][$club_user->id]['Game'] : 0) + array_sum($data['Game']);
                            $ballsTotal = (isset($count["total"][$club_user->id]['Balls']) ? round($count["total"][$club_user->id]['Balls'], 3) : 0) + array_sum($data['Balls']);

                            $rating_data['users'][$club_user->id] = array(
                                'Club' => $club->title,
                                'Player' => $club_user->name . ' ' . $club_user->last_name,
                                'Nickname' =>$club_user->nickname,
                                'Game' => $gamesTotal,
                                'Win' => (isset($count["total"][$club_user->id]['Win']) ? $count["total"][$club_user->id]['Win'] : 0) + array_sum($data['Win']),
                                'WR' => (isset($count["total"][$club_user->id]['WR']) ? $count["total"][$club_user->id]['WR'] : 0) + array_sum($data['WR']),
                                'WB' => (isset($count["total"][$club_user->id]['WB']) ? $count["total"][$club_user->id]['WB'] : 0) + array_sum($data['WB']),
                                'Fail' => (isset($count["total"][$club_user->id]['Fail']) ? $count["total"][$club_user->id]['Fail'] : 0) + array_sum($data['Fail']),
                                'Citizen' => (isset($count["total"][$club_user->id]['Citizen']) ? $count["total"][$club_user->id]['Citizen'] : 0) + array_sum($data['Citizen']),
                                'Mafia' => (isset($count["total"][$club_user->id]['Mafia']) ? $count["total"][$club_user->id]['Mafia'] : 0) + array_sum($data['Mafia']),
                                'Sheriff' => (isset($count["total"][$club_user->id]['Sheriff']) ? $count["total"][$club_user->id]['Sheriff'] : 0) + array_sum($data['Sheriff']),
                                'Sheriff_Win' => (isset($count["total"][$club_user->id]['Sheriff_Win']) ? $count["total"][$club_user->id]['Sheriff_Win'] : 0) + array_sum($data['Sheriff_Win']),
                                'Don' => (isset($count["total"][$club_user->id]['Don']) ? $count["total"][$club_user->id]['Don'] : 0) + array_sum($data['Don']),
                                'Don_Win' => (isset($count["total"][$club_user->id]['Don_Win']) ? $count["total"][$club_user->id]['Don_Win'] : 0) + array_sum($data['Don_Win']),
                                'BM' => (isset($count["total"][$club_user->id]['BM']) ? $count["total"][$club_user->id]['BM'] : 0) + array_sum($data['BM']),
                                'BP' => (isset($count["total"][$club_user->id]['BP']) ? $count["total"][$club_user->id]['BP'] : 0) + array_sum($data['BP']),
                                'PN' => $pn,
                                'Balls' => $ballsTotal,
                                'Score' =>  ($ballsTotal/$gamesTotal) + (in_array($club_user->id, $worldCupUserIds ) ? 0.2 : 0.1) +(in_array($club_user->id, array_keys($firstThree) ) ? $firstThree[$club_user->id] : 0) ,
                            );
                        } else {
                            $gamesTotal = isset($count["total"][$club_user->id]['Game']) ? $count["total"][$club_user->id]['Game'] : 0;
                            $ballsTotal = isset($count["total"][$club_user->id]['Balls']) ? round($count["total"][$club_user->id]['Balls'], 3) : 0;

                            $pn = Helpers::getPrimaNota($club_user->id, null, null, 'global', null);

                            $rating_data['users'][$club_user->id] = array(
                                'Club' => $club->title,
                                'Player' => $club_user->name . ' ' . $club_user->last_name,
                                'Nickname' =>$club_user->nickname,
                                'Game' => $gamesTotal,
                                'Win' => isset($count["total"][$club_user->id]['Win']) ? $count["total"][$club_user->id]['Win'] : 0,
                                'WR' => isset($count["total"][$club_user->id]['WR']) ? $count["total"][$club_user->id]['WR'] : 0,
                                'WB' => isset($count["total"][$club_user->id]['WB']) ? $count["total"][$club_user->id]['WB'] : 0,
                                'Fail' => isset($count["total"][$club_user->id]['Fail']) ? $count["total"][$club_user->id]['Fail'] : 0,
                                'Citizen' => isset($count["total"][$club_user->id]['Citizen']) ? $count["total"][$club_user->id]['Citizen'] : 0,
                                'Mafia' => isset($count["total"][$club_user->id]['Mafia']) ? $count["total"][$club_user->id]['Mafia'] : 0,
                                'Sheriff' => isset($count["total"][$club_user->id]['Sheriff']) ? $count["total"][$club_user->id]['Sheriff'] : 0,
                                'Sheriff_Win' => isset($count["total"][$club_user->id]['Sheriff_Win']) ? $count["total"][$club_user->id]['Sheriff_Win'] : 0,
                                'Don' => isset($count["total"][$club_user->id]['Don']) ? $count["total"][$club_user->id]['Don'] : 0,
                                'Don_Win' => isset($count["total"][$club_user->id]['Don_Win']) ? $count["total"][$club_user->id]['Don_Win'] : 0,
                                'BM' => isset($count["total"][$club_user->id]['BM']) ? $count["total"][$club_user->id]['BM'] : 0,
                                'BP' => isset($count["total"][$club_user->id]['BP']) ? $count["total"][$club_user->id]['BP'] : 0,
                                'PN' => $pn,
                                'Balls' => $ballsTotal,
                                'Score' => ($ballsTotal/$gamesTotal) + (in_array($club_user->id, $worldCupUserIds ) ? 0.2 : 0) +(in_array($club_user->id, array_keys($firstThree) ) ? $firstThree[$club_user->id] : 0),
                            );
                        }
                    }
                }
            }
        }

        return $rating_data;
    }


    public function globalRating($id) {
        $clubs = Club::get();

        $global = GlobalRating::find($id);

        if(!$global) abort(404);

        $rating_data = array();
        $start = null;
        $end = null;

        if($global) {
            $start = $global->from_date;
            $end = $global->to_date;
        }


        $globalRatings = $this->clubsGlobalRating($id);

        foreach ($globalRatings['users'] as $rating) {
            if( $rating['Game'] >= 60 ) $rating_data['users'][] = $rating;
        }


        return view('globalRating', [
            'club' => null,
            'rating_data' => isset($rating_data) ? json_encode($rating_data) : json_encode(array()),
            'seasons' => [],
            'eligibel_value' =>(isset($rating_data) && count($rating_data)) ? $this->eligibelValue($rating_data) : 0,
            'global' => $global
        ]);
    }

}
