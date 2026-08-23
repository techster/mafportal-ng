<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Backpack\CRUD\CrudTrait;
use Cviebrock\EloquentSluggable\Sluggable;
use Cviebrock\EloquentSluggable\SluggableScopeHelpers;

class Game_rating extends Model
{
    use CrudTrait;
    use Sluggable;
    use SluggableScopeHelpers;

     /*
    |--------------------------------------------------------------------------
    | GLOBAL VARIABLES
    |--------------------------------------------------------------------------
    */
    protected $table = 'game_ratings';
    protected $primaryKey = 'id';
    protected $fakeColumns = ['extra_field'];
    protected $fillable = [
        'title',
        'slug',
        'club_id',
        'tournament_id',
        'table_ratings_id',
        'moderator',
        'best_move',
        'best_move2',
        'best_player',
        'cool_citizen',
        'prima_nota',
        'select_prima',
        'results',
        'extra_field',
        'sentence'
    ];
    protected $casts = [
        'extra_field' => 'array',
    ];

    /**
     * Return the sluggable configuration array for this model.
     *
     * @return array
     */
    public function sluggable()
    {
        return [
            'slug' => [
                'source' => 'slug_or_title',
            ],
        ];
    }

    /*
    |--------------------------------------------------------------------------
    | FUNCTIONS
    |--------------------------------------------------------------------------
    */
    public function club()
    {
        return $this->belongsTo('App\Models\Club');
    }

    public function tournament()
    {
        return $this->belongsTo('App\Models\Tournament');
    }

    public function table_ratings()
    {
        return $this->belongsTo('App\Models\Table_rating');
    }

    public function bestPlayer()
    {
        return $this->belongsTo('App\User', 'best_player');
    }

    public function bestMove()
    {
        return $this->belongsTo('App\User', 'best_move');
    }

    public function bestMove2()
    {
        return $this->belongsTo('App\User', 'best_move2');
    }

    public function coolPlayer()
    {
        return $this->belongsTo('App\User', 'cool_citizen');
    }

    public function primaNota()
    {
        return $this->belongsTo('App\User', 'prima_nota');
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

    // The slug is created automatically from the "name" field if no slug exists.
    public function getSlugOrTitleAttribute()
    {
        if ($this->slug != '') {
            return $this->slug;
        }

        return $this->title;
    }

    /*
    |--------------------------------------------------------------------------
    | MUTATORS
    |--------------------------------------------------------------------------
    */
}
