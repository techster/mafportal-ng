<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Support\Facades\DB;

class MoveWorldCupToTopMenu extends Migration
{
    public function up()
    {
        $tournaments = DB::table('menu_items')->where('link', 'tournaments')->first();
        $worldCup = DB::table('menu_items')->where('link', 'mafworldcup-history')->first();

        if (!$tournaments || !$worldCup) {
            return;
        }

        $insertPosition = (int) $tournaments->lft + 2;

        DB::table('menu_items')
            ->whereNull('parent_id')
            ->where('lft', '>=', $insertPosition)
            ->increment('lft', 2);
        DB::table('menu_items')
            ->whereNull('parent_id')
            ->where('rgt', '>=', $insertPosition)
            ->increment('rgt', 2);

        DB::table('menu_items')->where('id', $worldCup->id)->update([
            'parent_id' => null,
            'lft' => $insertPosition,
            'rgt' => $insertPosition + 1,
            'depth' => 1,
        ]);
    }

    public function down()
    {
        $worldCup = DB::table('menu_items')->where('link', 'mafworldcup-history')->first();
        $game = DB::table('menu_items')->where('link', 'the-game')->first();

        if (!$worldCup || !$game) {
            return;
        }

        $position = (int) $worldCup->lft;
        DB::table('menu_items')->where('id', $worldCup->id)->update([
            'parent_id' => $game->id,
            'lft' => null,
            'rgt' => null,
            'depth' => 1,
        ]);
        DB::table('menu_items')
            ->whereNull('parent_id')
            ->where('lft', '>', $position)
            ->decrement('lft', 2);
        DB::table('menu_items')
            ->whereNull('parent_id')
            ->where('rgt', '>', $position)
            ->decrement('rgt', 2);
    }
}
