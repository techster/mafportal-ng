<?php

namespace App\Http\Controllers;

use App\Helpers;
use App\Models\Game_rating;
use App\Models\Photo_gallery;
use App\Models\Season;
use App\Models\Tournament;
use App\Models\Video_gallery;
use App\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\App;
use Illuminate\Support\Facades\Cache;
use PhpParser\Node\Expr\Cast\Object_;
use stdClass;
use Validator;
use Mail;
class TournamentController extends Controller
{
    // Список турниров
    public function index()
    {

        //Cache::flush();

//        $tournaments = Cache::remember('tournament', 10, function () {
//            return Tournament::orderBy('id', 'desc')->paginate(10);
//        });

        $tournaments = Tournament::orderBy('created_at', 'asc')->paginate(25);
        return view('tournaments', ['tournaments' => $tournaments]);

    }

    // Одиночная клуба
    public function show($slug)
    {
        return redirect()->route('tournaments_about', $slug);
    }

    // О турнире
    public function about($slug)
    {
        $tournament = Tournament::findBySlug($slug);
        if(!$tournament) abort(404);
        $next_tournament = Tournament::orderBy("created_at", 'asc')->where('created_at', '>', $tournament->created_at)->first();
        $prev_tournament = Tournament::orderBy("created_at", 'desc')->where('created_at', '<', $tournament->created_at)->first();
        $meta_title = $tournament->meta_title;
        $meta_title_ru = $tournament->meta_title_ru;
        $meta_description_ru = $tournament->meta_description_ru;
        $meta_description = $tournament->meta_description;


        return view('tournaments-single', [
            'tournament' => $tournament,
            'next_tournament' => $next_tournament,
            'prev_tournament' => $prev_tournament,

            'meta_title' =>              isset($meta_title)?(App::getLocale() == 'ru'?$meta_title_ru:$meta_title):NULL,
            'meta_description' =>        isset($meta_description)?(App::getLocale() == 'ru'?$meta_description_ru:$meta_description):NULL,
            'meta_keywords' =>           NULL,
            'social_meta_title' =>       isset($meta_title)?(App::getLocale() == 'ru'?$meta_title_ru:$meta_title):NULL,
            'social_meta_description' => isset($meta_description)?(App::getLocale() == 'ru'?$meta_description_ru:$meta_description):NULL,

        ]);
    }

    // Рейтинги турнира
    public function rating($slug)
    {
        $tournament = Tournament::findBySlug($slug);

        if(!$tournament) abort(404);

        if($tournament->table_ratings and count($tournament->game_ratings)) {
            $count = $this->count_points($tournament);

            // Выводим результат
            $rating_data = array();
            foreach($count["total"] as $key => $user){
                $pn = Helpers::getPrimaNota($key, null, null, 'tournament', $tournament->id);

                $player = User::find($key);
                $club = $player->clubs->toArray();
                $avatar = $this->resolveAvatar($player->avatar);

                $rating_data['users'][] = array(
                    'Player'  => $player->name.' '.$player->last_name,
                    'Nickname' => $player->nickname,
                    'Avatar' => $avatar,
                    'AvatarFallback' => $avatar === '/images/avatar-silhouette.svg',
                    'Main_Club' => isset($club[0]) && !empty($club[0])  ? $club[0]['title']: '',
                    'Played_Game' => $user['Don_Win'],
                    'Game'    => $user['Game'],
                    'Win'     => $user['Win'],
                    'Clean_Win' => $user['Clean_Win'],
                    'WR'      => $user['WR'],
                    'WB'      => $user['WB'],
                    'Fail'    => $user['Fail'],
                    'Citizen' => $user['Citizen'],
                    'Mafia'   => $user['Mafia'],
                    'Sheriff' => $user['Sheriff'],
                    'Sheriff_Win' => $user['Sheriff_Win'],
                    'Don'     => $user['Don'],
                    'Don_Win'     => $user['Don_Win'],
                    'BM'      => $user['BM'],
                    'BP'      => $user['BP'],
                    'PN'      => $pn,
                    'Balls'   => round($user['Balls'],3),
                    'Score'   => round($user['Score'],3),

                );
            }
        }

        return view('tournaments-rating', [
            'tournament' => $tournament,
            'rating_data' => isset($rating_data) ? json_encode($rating_data) : json_encode(array()),
        ]);
    }

    private function resolveAvatar($storedAvatar)
    {
        $avatarName = $storedAvatar
            ? basename(urldecode(parse_url($storedAvatar, PHP_URL_PATH)))
            : null;

        if (!$avatarName || $avatarName === '.' || $avatarName === DIRECTORY_SEPARATOR) {
            return '/images/avatar-silhouette.svg';
        }

        $locations = [
            ['directory' => public_path('avatars'), 'url' => '/avatars/'],
            ['directory' => public_path('uploads/users/avatar'), 'url' => '/uploads/users/avatar/'],
        ];

        foreach ($locations as $location) {
            $exactPath = $location['directory'].DIRECTORY_SEPARATOR.$avatarName;
            if (is_file($exactPath)) {
                return $location['url'].$avatarName;
            }

            $matches = glob($location['directory'].DIRECTORY_SEPARATOR.pathinfo($avatarName, PATHINFO_FILENAME).'.*');
            if (!empty($matches)) {
                return $location['url'].basename($matches[0]);
            }
        }

        return '/images/avatar-silhouette.svg';
    }

    public function globalTournamentRating($start, $end) {
        $tournaments = Tournament::get();

        foreach ($tournaments as $tournament) {
            if($tournament->table_ratings and count($tournament->game_ratings)) {
                $count = $this->count_points($tournament, $start, $end);
                if(isset($count['total'])) {
                    foreach($count["total"] as $key => $user) {
                        $rating_data['users'][$key][] = array(
                            'Player'  => User::find($key)->name.' '.User::find($key)->last_name,
                            'Nickname' => User::find($key)->nickname,
                            'Game'    => $user['Game'],
                            'Win'     => $user['Win'],
                            'Clean_Win' => $user['Clean_Win'],
                            'WR'      => $user['WR'],
                            'WB'      => $user['WB'],
                            'Fail'    => $user['Fail'],
                            'Citizen' => $user['Citizen'],
                            'Mafia'   => $user['Mafia'],
                            'Sheriff' => $user['Sheriff'],
                            'Sheriff_Win' => $user['Sheriff_Win'],
                            'Don'     => $user['Don'],
                            'Don_Win'     => $user['Don_Win'],
                            'BM'      => $user['BM'],
                            'BP'      => $user['BP'],
                            'Balls'   => round($user['Balls'],3),
                            'Score'   => round($user['Score'],3),
                        );
                    }
                }
            }

        }
        return $rating_data;
    }
    // Галерея
    public function gallery($slug)
    {
        $tournament = Tournament::findBySlug($slug);
        if(!$tournament) abort(404);
        $PhotoGalleries = Photo_gallery::where('tournament_id', '=', $tournament->id)->orderBy('id', 'desc')->paginate(99);
        $VideoGalleries = Video_gallery::where('tournament_id', '=', $tournament->id)->orderBy('id', 'desc')->paginate(99);

        return view('tournaments-gallery', [
            'tournament' => $tournament,
            'PhotoGalleries' => $PhotoGalleries,
            'VideoGalleries' => $VideoGalleries
        ]);
    }

    // live
    public function live($slug)
    {
        $tournament = Tournament::findBySlug($slug);
        if(!$tournament) abort(404);


        return view('live', [
            'tournament' => $tournament,
        ]);
    }

    // Расписание
    public function schedule($slug)
    {
        $tournament = Tournament::findBySlug($slug);
        if(!$tournament) abort(404);
        $roles = array("0" => "", "1" => "Citizen", "2" => "Sheriff", "3" => "Mafia", "4" => "Don",);
        $count = $this->count_points($tournament);

        // Выводим результат
        $rating_data = array();
        if(isset($count["by_game"])){
            foreach ($count["by_game"] as $key => $game) {
                foreach ($game as $key2 => $user) {
                    $rating_data[$key][] = array(
                        'Player'     => User::find($key2)->name . ' ' . User::find($key2)->last_name . (User::find($key2)->nickname?' (' . User::find($key2)->nickname . ')':""),
                        'Role'       => $roles[$user["role"]],
                        'Result'     => ($user["role"]?$user["result"]:""),
                        'Points'     => ($user["role"]?$user["points"]:""),
                        'Add_Points' => ($user["role"]?$user["penalty"]:""),
                    );
                }
            }
        }

        return view('tournaments-schedule', [
            'tournament' => $tournament,
            'rating_data' => isset($rating_data) ? json_encode($rating_data) : json_encode(array()),
        ]);
    }

    // Одиночная игра
    public function single_game($slug, $game_slug)
    {
        $tournament = Tournament::findBySlug($slug);
        $game = Game_rating::findBySlug($game_slug);
        if(!$game) abort(404);
        $next_game = Game_rating::orderBy("created_at", 'asc')->where('created_at', '>', $game->created_at)->first();
        $prev_game = Game_rating::orderBy("created_at", 'desc')->where('created_at', '<', $game->created_at)->first();
        $metas_data = json_decode($game->metas);

        return view('tournaments-game', [
            'tournament' => $tournament,
            'game' => $game,
            'next_game' => $next_game,
            'prev_game' => $prev_game,

            'meta_title' =>              isset($metas_data)?(App::getLocale() == 'ru'?$metas_data->meta_title_ru:$metas_data->meta_title_en):NULL,
            'meta_description' =>        isset($metas_data)?(App::getLocale() == 'ru'?$metas_data->meta_description_ru:$metas_data->meta_description_en):NULL,
            'meta_keywords' =>           isset($metas_data)?(App::getLocale() == 'ru'?$metas_data->meta_keywords_ru:$metas_data->meta_keywords_en):NULL,
            'social_meta_title' =>       isset($metas_data)?(App::getLocale() == 'ru'?$metas_data->social_meta_title_ru:$metas_data->social_meta_title_en):NULL,
            'social_meta_description' => isset($metas_data)?(App::getLocale() == 'ru'?$metas_data->social_meta_description_ru:$metas_data->social_meta_description_en):NULL,
        ]);
    }


    // Расчет балов
    public function count_points($tournament, $start = null, $end = null){
        if (!$tournament) {
            return array('total' => array(), 'by_game' => array());
        }

        if (isset($_GET['season'])  ) {
            $season_id = $_GET['season'];
            $season_data = Season::where('id', $season_id)->get();
            $season_start =  $season_data[0]->start ;
            $season_end =  $season_data[0]->end;

            if($tournament->game_ratings) {
                foreach ($tournament->game_ratings as $key => $game_rating ) {

                    if ($game_rating->created_at->toDateTimeString() <= $season_start
                        || $game_rating->created_at->toDateTimeString() >= $season_end) {

                        unset($tournament->game_ratings[$key] );
                    }

                }
            }
        }
        if( $start && $end ) {
            foreach ($tournament->game_ratings as $key => $game_rating ) {

                if ($game_rating->created_at->toDateTimeString() <= $start
                    || $game_rating->created_at->toDateTimeString() >= $end) {

                    unset($tournament->game_ratings[$key] );
                }

            }
        }

        $count = array();
        foreach($tournament->game_ratings as $game) {
            $table_rating = $game->table_ratings ? $game->table_ratings : $tournament->table_ratings;

            if (isset($game->results) && $game->results) {
                foreach (json_decode($game->results) as $player_result) {
                    if (!isset($player_result->player) || !$player_result->player || $player_result->player == 239) continue;
                    $id = $player_result->player;
                    $count["by_game"][$game->id][$id] = array("role" => "0", "result" => "", "points" => "", "penalty" => "");
                    if (!$tournament->table_ratings) continue;
                    // who win
                    $cit_win = ($player_result->role == 1 || $player_result->role == 2) && ($game->sentence == 1);
                    $sheriff_win = ($player_result->role == 2) && ($game->sentence == 1);
                    $don_win = ($player_result->role == 4 ) && ($game->sentence == 2);
                    $maf_win = ($player_result->role == 3 || $player_result->role == 4) && ($game->sentence == 2);

                    // who fail
                    $cit_fail = ($player_result->role == 1 || $player_result->role == 2) && ($game->sentence == 2);
                    $maf_fail = ($player_result->role == 3 || $player_result->role == 4) && ($game->sentence == 1);

                    $win = ($cit_win || $maf_win ? 1 : 0);
                    $fail = (!$maf_win && !$cit_win && $game->sentence && $player_result->role ? 1 : 0);
                    $game_count = ($player_result->role > 0 ? 1 : 0);

                    // clean win
                    $somebody_clean_win = false;

                    if (isset($table_rating->extra_field) && $table_rating->extra_field) {
                        foreach ($table_rating->extra_field as $item) {
                            if ( $item && isset($item->name) && ($item->name == "Citizens clean win" || $item->name == "Mafia clean win") ) {
                                if ($game->withFakes()["extra_" . $item->id] > 0) {
                                    $somebody_clean_win = true;
                                    break;
                                }
                                $clean_win_ids[] = $game->withFakes()["extra_" . $item->id];
                            }
                        }
                    }
                    $clean_win = ($win && $somebody_clean_win ? 1 : 0);

                    // Количество игр, побед и поражений
                    $count["total"][$id]['Game'] = isset($count["total"][$id]['Game']) ? $count["total"][$id]['Game'] + $game_count : $game_count;
                    $count["total"][$id]['Win'] = isset($count["total"][$id]['Win']) ? $count["total"][$id]['Win'] + $win : $win;
                    $count["total"][$id]['Clean_Win'] = isset($count["total"][$id]['Clean_Win']) ? $count["total"][$id]['Clean_Win'] + $clean_win : $clean_win;
                    $count["total"][$id]['WR'] = isset($count["total"][$id]['WR']) ? $count["total"][$id]['WR'] + ($cit_win ? 1 : 0) : ($cit_win ? 1 : 0);
                    $count["total"][$id]['WB'] = isset($count["total"][$id]['WB']) ? $count["total"][$id]['WB'] + ($maf_win ? 1 : 0) : ($maf_win ? 1 : 0);
                    $count["total"][$id]['Fail'] = isset($count["total"][$id]['Fail']) ? $count["total"][$id]['Fail'] + $fail : $fail;
                    $count["total"][$id]['Citizen'] = isset($count["total"][$id]['Citizen']) ? $count["total"][$id]['Citizen'] + ($player_result->role == 1 ? 1 : 0) : ($player_result->role == 1 ? 1 : 0);
                    $count["total"][$id]['Mafia'] = isset($count["total"][$id]['Mafia']) ? $count["total"][$id]['Mafia'] + ($player_result->role == 3 ? 1 : 0) : ($player_result->role == 3 ? 1 : 0);
                    $count["total"][$id]['Sheriff'] = isset($count["total"][$id]['Sheriff']) ? $count["total"][$id]['Sheriff'] + ($player_result->role == 2 ? 1 : 0) : ($player_result->role == 2 ? 1 : 0);
                    $count["total"][$id]['Sheriff_Win'] = isset($count["total"][$id]['Sheriff_Win']) ? $count["total"][$id]['Sheriff_Win'] + ($sheriff_win ? 1 : 0) : ($sheriff_win ? 1 : 0);
                    $count["total"][$id]['Don'] = isset($count["total"][$id]['Don']) ? $count["total"][$id]['Don'] + ($player_result->role == 4 ? 1 : 0) : ($player_result->role == 4 ? 1 : 0);
                    $count["total"][$id]['Don_Win'] = isset($count["total"][$id]['Don_Win']) ? $count["total"][$id]['Don_Win'] + ($don_win ? 1 : 0) : ($don_win ? 1 : 0);
                    $count["total"][$id]['BM'] = isset($count["total"][$id]['BM']) ? $count["total"][$id]['BM'] + ($game->best_move == $id || $game->best_move2 == $id ? 1 : 0) : ($game->best_move == $id || $game->best_move2 == $id ? 1 : 0);
                    $count["total"][$id]['BP'] = isset($count["total"][$id]['BP']) ? $count["total"][$id]['BP'] + ($game->best_player == $id ? 1 : 0) : ($game->best_player == $id ? 1 : 0);

                    // Подсчет балов
                    $sum_BM = ($game->best_move == $id || $game->best_move2 == $id ? $table_rating->best_step : 0);
                    $sum_BP = ($game->best_player == $id ? $table_rating->best_player : 0);
                    $sum_win_Cit = ($player_result->role == 1 && $game->sentence == 1 ? $table_rating->win_citizen : 0);
                    $sum_win_Sheriff = ($player_result->role == 2 && $game->sentence == 1 ? $table_rating->win_sheriff : 0);
                    $sum_win_Maf = ($player_result->role == 3 && $game->sentence == 2 ? $table_rating->win_mafia : 0);
                    $sum_win_Don = ($player_result->role == 4 && $game->sentence == 2 ? $table_rating->win_don : 0);
                    $sum_fail_Cit = ($player_result->role == 1 && $game->sentence == 2 ? $table_rating->fail_citizen : 0);
                    $sum_fail_Sheriff = ($player_result->role == 2 && $game->sentence == 2 ? $table_rating->fail_sheriff : 0);
                    $sum_fail_Maf = ($player_result->role == 3 && $game->sentence == 1 ? $table_rating->fail_mafia : 0);
                    $sum_fail_Don = ($player_result->role == 4 && $game->sentence == 1 ? $table_rating->fail_don : 0);
                    $sum_cool_citizen = ($game->cool_citizen == $id ? $table_rating->citizen_killed : 0);
                    $prima_nota3 = ($game->prima_nota == $id && $game->select_prima == 3 ? $table_rating->prima_nota3 : 0);
                    $prima_nota2 = ($game->prima_nota == $id && $game->select_prima == 2 ? $table_rating->prima_nota2 : 0);

                    // Формула
                    if ($table_rating->formula) {
                        $formula = $table_rating->formula;
                    } else {
                        $formula = "#1# + #2# + #3# + #4# + #5# + #6# + #7# + #8# + #9# + #10# + #11# + #12# + #13#";

                        // if (isset($table_rating->extra_field) && $table_rating->extra_field) {
                        //     foreach ($table_rating->extra_field as $item) {
                        //         if (!isset($item->id) || !$item->id) continue;
                        //         $formula = $formula . " + #e" . $item->id . "#";
                        //     }
                        // }
                    }

                    $formula = str_replace("#1#", $sum_win_Cit, $formula);
                    $formula = str_replace("#2#", $sum_win_Sheriff, $formula);
                    $formula = str_replace("#3#", $sum_win_Maf, $formula);
                    $formula = str_replace("#4#", $sum_win_Don, $formula);
                    $formula = str_replace("#5#", $sum_fail_Cit, $formula);
                    $formula = str_replace("#6#", $sum_fail_Sheriff, $formula);
                    $formula = str_replace("#7#", $sum_fail_Maf, $formula);
                    $formula = str_replace("#8#", $sum_fail_Don, $formula);
                    $formula = str_replace("#9#", $sum_BP, $formula);
                    $formula = str_replace("#10#", $sum_BM, $formula);
                    $formula = str_replace("#11#", $sum_cool_citizen, $formula);
                    $formula = str_replace("#12#", $prima_nota3, $formula);
                    $formula = str_replace("#13#", $prima_nota2, $formula);

                    if (isset($table_rating->extra_field) && $table_rating->extra_field) {
                        foreach ($table_rating->extra_field as $item) {
                            if (!isset($item->id) || !$item->id) continue;
                            if (!isset($item->type) || !$item->type) continue;
                            if (!isset($item->points) || !$item->points) $item->points = 0;

                            $item_id = str_replace("#", "", $item->id);
                            $game_extra_field = json_decode($game->extra_field, true);

                            $item_balls = 0;
                            if ($item->type == "user" && isset($game_extra_field["extra_" . $item_id]) && $game_extra_field["extra_" . $item_id] == $id) $item_balls = $item->points;
                            if (
                                $item->type == "checkbox" &&
                                isset($game_extra_field["extra_" . $item_id]) &&
                                $game_extra_field["extra_" . $item_id] == 1 &&
                                (
                                    (!isset($item->condition1) && !isset($item->condition2)) ||
                                    ($item->condition1 == "red" && !isset($item->condition2) && ($player_result->role == 1 || $player_result->role == 2)) ||
                                    ($item->condition1 == "black" && !isset($item->condition2) && ($player_result->role == 3 || $player_result->role == 4)) ||
                                    ($item->condition1 == "citizen" && !isset($item->condition2) && $player_result->role == 1) ||
                                    ($item->condition1 == "sheriff" && !isset($item->condition2) && $player_result->role == 2) ||
                                    ($item->condition1 == "mafia" && !isset($item->condition2) && $player_result->role == 3) ||
                                    ($item->condition1 == "don" && !isset($item->condition2) && $player_result->role == 4) ||

                                    (!isset($item->condition1) && $item->condition2 == "win" && $win) ||
                                    ($item->condition1 == "red" && $item->condition2 == "win" && $cit_win) ||
                                    ($item->condition1 == "black" && $item->condition2 == "win" && $maf_win) ||
                                    ($item->condition1 == "citizen" && $item->condition2 == "win" && $player_result->role == 1 && $cit_win) ||
                                    ($item->condition1 == "sheriff" && $item->condition2 == "win" && $player_result->role == 2 && $cit_win) ||
                                    ($item->condition1 == "mafia" && $item->condition2 == "win" && $player_result->role == 3 && $maf_win) ||
                                    ($item->condition1 == "don" && $item->condition2 == "win" && $player_result->role == 4 && $maf_win) ||

                                    (!isset($item->condition1) && $item->condition2 == "fail" && $fail) ||
                                    ($item->condition1 == "red" && $item->condition2 == "fail" && $cit_fail) ||
                                    ($item->condition1 == "black" && $item->condition2 == "fail" && $maf_fail) ||
                                    ($item->condition1 == "citizen" && $item->condition2 == "fail" && $player_result->role == 1 && $cit_fail) ||
                                    ($item->condition1 == "sheriff" && $item->condition2 == "fail" && $player_result->role == 2 && $cit_fail) ||
                                    ($item->condition1 == "mafia" && $item->condition2 == "fail" && $player_result->role == 3 && $maf_fail) ||
                                    ($item->condition1 == "don" && $item->condition2 == "fail" && $player_result->role == 4 && $maf_fail)
                                )
                            ) {
                                $item_balls = $item->points;
                            }

                            $formula = str_replace("#e" . $item->id . "#", $item_balls, $formula);
                        }
                    }
                    $parser = new \Math\Parser();
                    $formula = trim($formula);
                    $formula = preg_replace('/(?:\s*[+\-*\/%]\s*)+$/', '', $formula);
                    $balls = $formula === '' ? 0 : $parser->evaluate($formula);


                    // By game
                    $count["by_game"][$game->id][$id]['role'] = $player_result->role;
                    $count["by_game"][$game->id][$id]['result'] = ($win ? "Win" : "Fail");
                    $count["by_game"][$game->id][$id]['points'] = $balls;
                    $count["by_game"][$game->id][$id]['penalty'] = (isset($player_result->penalty) && $player_result->penalty ? $player_result->penalty : 0);

                    $balls = $balls + (isset($player_result->penalty) && $player_result->penalty ? $player_result->penalty : 0);

                    $count["total"][$id]['Balls'] = isset($count["total"][$id]['Balls']) ? $count["total"][$id]['Balls'] + $balls : $balls;
                    $count["total"][$id]['Score'] = isset($count["total"][$id]['Balls']) && isset($count["total"][$id]['Game']) && $count["total"][$id]['Game'] > 0 ? round($count["total"][$id]['Balls'] / $count["total"][$id]['Game'], 2) : 0;
                }
            }
        }
        return $count;
    }

    public function contactForm(Request $request) {

        if($request->isMethod('post')) {

            $rules = [
                'fname' => 'required',
                'lname' => 'required',
                'email' => 'required|email',
                'g-recaptcha-response' => 'required'
            ];
            $validator = Validator::make($request->all(), $rules);

            if ($validator->fails()) return redirect()->back()->withErrors([$validator->messages()->first()]);

            $res = json_decode( file_get_contents('https://www.google.com/recaptcha/api/siteverify?secret=6LfEJYMUAAAAAG4gidCFERhog4emoYaMwrKj26I5&response='.request('g-recaptcha-response').''));

            if(!$res->success) return redirect()->back()->withErrors("Captcha is incurrect.");

            $data = $request->all();

            Mail::send('emails.tournamentContact', ['data' => $data], function ($m) use ($data) {
                $m->from($data['email'], "Info@".$data['tournament']);

                $m->to('info@mafportal.com')->cc('drhagopjanian@yahoo.com');
            });

            return redirect()->back()->withSuccess('Thanks for submit your request. We will contact you soon.');
        }

    }

}
