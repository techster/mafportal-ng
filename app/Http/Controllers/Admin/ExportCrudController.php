<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Club;
use App\Models\Game_rating;
use App\User;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;


class ExportCrudController extends Controller
{
    public function index()
    {
        $users = User::orderBy('name')->get();

        return view('export.index', compact('users'));
    }




    public function show(Request $request)
    {
        $from =  Carbon::parse($request['from-date'])->format('Y-m-d H:i:s');
        $to = Carbon::parse($request['to-date'])->format('Y-m-d'). ' 23:59:00';

        $gameRatings = Game_rating::where('results', 'like', '%' . $request['user_id'] . '%')
            ->whereBetween('created_at', [$from, $to])
            ->get();

        $exportGameRating = [];
        $user = '';
        $mafiaGuessedTotal = 0;
        $additionalTotal = 0;
        foreach ($gameRatings as $gameRating){
            if($gameRating->sentence == 0){
                $sentence = 'DRAW';
            }elseif ($gameRating->sentence == 1){
                $sentence = 'CITIZENS WON';
            }elseif ($gameRating->sentence == 2) {
                $sentence = 'MAFIA WON';
            }else{
                $sentence = '';
            }


            $role = '';
            $additional = '';
            $user = '';
            foreach (json_decode($gameRating->results) as $item){
                if(isset($item->player) && $item->player === $request['user_id']){
                    $additional = $item->key_id;
                    if($item->role === "1"){
                        $role = 'Citizen';
                    }elseif ($item->role === "2"){
                        $role = 'Sheriff';
                    }elseif ($item->role === "3"){
                        $role = 'Mafia';
                    }elseif ($item->role === "4"){
                        $role = 'Don';
                    }else{
                        $role = '';
                    }

                    $userData = User::where('id', $item->player)->first();

                    if(isset($userData)){
                        $user = $userData->name . ' '. $userData->last_name;
                    }
                }


            }


            $mafiaGuessedTotal += $gameRating->select_prima;
            $additionalTotal += $additional ? $additional : 0;

            $exportGameRating[] = [
                'Game Name'               =>  $gameRating->title,
                'Club'                    =>  $gameRating->club != null ? $gameRating->club->title : "",
                'Tournament'              =>  $gameRating->tournament != null ? $gameRating->tournament->title : "",
                'Rating table'            =>  $gameRating->table_ratings != null ? $gameRating->table_ratings->title : "",
                'The outcome of the game' =>  $sentence,
                'Player'                  =>  $user,
                'Role'                    =>  $role,
                'Result'                  =>  $gameRating->sentence == 2 ? 'Mafia' : 'Citizens',
                'Additional points'       =>  $additional,
                'Best player'             =>  $gameRating->bestPlayer != null ? $gameRating->bestPlayer->name . ' '. $gameRating->bestPlayer->last_name : '',
                'Best move 1'             =>  $gameRating->bestMove != null ? $gameRating->bestMove->name . ' '. $gameRating->bestMove->last_name : '',
                'Best move 2'             =>  $gameRating->bestMove2 != null ? $gameRating->bestMove2->name . ' '. $gameRating->bestMove2->last_name : '',
                'Cool player'             =>  $gameRating->coolPlayer != null ? $gameRating->coolPlayer->name . ' '. $gameRating->coolPlayer->last_name : '',
                'Prima nota'              =>  $gameRating->primaNota != null ? $gameRating->primaNota->name . ' '. $gameRating->primaNota->last_name : '',
                'Mafia guessed'           =>  $gameRating->select_prima,

            ];
        }


        $footer[] = [
            'Total Game Name'               =>  'Total Game Name',
            'Total Club'                    =>  'Total Club',
            'Total Tournament'              =>  'Total Tournament',
            'Total Rating table'            =>  'Total Rating table',
            'Total The outcome of the game' =>  'Total The outcome of the game',
            'Total Player'                  =>  'Total Player',
            'Total Role'                    =>  'Total Role',
            'Total Result'                  =>  'Total Result',
            'Total Additional points'       =>  'Total Additional points',
            'Total Best player'             =>  'Total Best player',
            'Total Best move 1'             =>  'Total Best move 1',
            'Total Best move 2'             =>  'Total Best move 2',
            'Total Cool player'             =>  'Total Cool player',
            'Total Prima nota'              =>  'Total Prima nota',
            'Total Mafia guessed'           =>  'Total Mafia guessed',
        ];

        $footer[] = [
            'Total Game Name'               =>  '',
            'Total Club'                    =>  '',
            'Total Tournament'              =>  '',
            'Total Rating table'            =>  '',
            'Total The outcome of the game' =>  '',
            'Total Player'                  =>  '',
            'Total Role'                    =>  '',
            'Total Result'                  =>  '',
            'Total Additional points'       =>  $additionalTotal,
            'Total Best player'             =>  '',
            'Total Best move 1'             =>  '',
            'Total Best move 2'             =>  '',
            'Total Cool player'             =>  '',
            'Total Prima nota'              =>  '',
            'Total Mafia guessed'           =>  $mafiaGuessedTotal,
        ];

        $merged = array_merge($exportGameRating, $footer);


        if(!empty($merged)) {

            return \Excel::create($user, function($excel) use ($merged) {
                $excel->sheet('sheet name', function($sheet) use ($merged)
                {
                    $sheet->fromArray($merged);
                });
            })->download('csv');

        }else{
            return back()->withErrors(['The User do not have game']);
        }

    }


}
