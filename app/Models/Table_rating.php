<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Backpack\CRUD\CrudTrait;

class Table_rating extends Model
{
    use CrudTrait;

     /*
    |--------------------------------------------------------------------------
    | GLOBAL VARIABLES
    |--------------------------------------------------------------------------
    */

    protected $table = 'table_ratings';
    protected $primaryKey = 'id';
    protected $fillable = [
         'title',
         'club_id',
         'check_glob',
         'best_player',
         'best_step',
         'win_citizen',
         'win_sheriff',
         'win_mafia',
         'win_don',
         'fail_citizen',
         'fail_sheriff',
         'fail_mafia',
         'fail_don',
         'citizen_killed',
         'prima_nota3',
         'prima_nota2',
         'extra_field',
         'formula'
    ];
    protected $casts = [
        'extra_field' => 'object',
    ];

    /*
    |--------------------------------------------------------------------------
    | FUNCTIONS
    |--------------------------------------------------------------------------
    */
    public function club()
    {
        return $this->belongsTo('App\Models\Club');
    }
    /*
    |--------------------------------------------------------------------------
    | RELATIONS
    |--------------------------------------------------------------------------
    */

    /*
    |--------------------------------------------------------------------------
    | SCOPES
    |--------------------------------------------------------------------------
    */

    /*
    |--------------------------------------------------------------------------
    | ACCESORS
    |--------------------------------------------------------------------------
    */

    /*
    |--------------------------------------------------------------------------
    | MUTATORS
    |--------------------------------------------------------------------------
    */
}
