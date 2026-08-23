<?php

namespace App;


use App\Models\Game_rating;
use App\Models\Table_rating;

class Helpers
{
   public static function relativeLinks($content)
   {
       return preg_replace(
           '~https?://(?:www\.)?mafportal\.com(?::\d+)?(?=[/"?#]|$)~i',
           '',
           (string) $content
       );
   }

   public static function getPrimaNota($userId, $startDate, $endDate, $type, $turnament = null)
   {
       $gameRatings = Game_rating::where('prima_nota', $userId);

       if($type == 'club') {
           $gameRatings = $gameRatings->where('tournament_id', '=', null);
       }

       if($type == 'tournament') {
           $gameRatings = $gameRatings->where('tournament_id', '=', $turnament);
       }

       if($startDate && $endDate) {
           $gameRatings = $gameRatings->whereBetween('created_at', array($startDate, $endDate));
       }

       $gameRatings = $gameRatings->get();

       $primaNota2 = 0;
       $primaNota3 = 0;
       $selectPrima = 0;

       foreach ($gameRatings as $gameRating){
           $tableRatingsId = $gameRating->table_ratings_id ? $gameRating->table_ratings_id : 16;
           $tableRating =  Table_rating::where('id', $tableRatingsId)->first();
           $primaNota2 += isset($tableRating->prima_nota2) ? $tableRating->prima_nota2 : 0;
           $primaNota3 += isset($tableRating->prima_nota3) ? $tableRating->prima_nota3 : 0;
           $selectPrima = isset($gameRating->select_prima) ? $gameRating->select_prima : 0;
       }

       return $selectPrima == 2 ? $primaNota2 : $primaNota3;
   }
}
