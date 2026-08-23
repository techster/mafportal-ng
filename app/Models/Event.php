<?php

namespace App\Models;

use Carbon\Carbon;
use Illuminate\Database\Eloquent\Model;
use Backpack\CRUD\CrudTrait;
use Cviebrock\EloquentSluggable\Sluggable;
use Cviebrock\EloquentSluggable\SluggableScopeHelpers;
use Illuminate\Support\Facades\App;

class Event extends Model
{
    use CrudTrait;
    use Sluggable;
    use SluggableScopeHelpers;

     /*
    |--------------------------------------------------------------------------
    | GLOBAL VARIABLES
    |--------------------------------------------------------------------------
    */
    protected $table = 'events';
    protected $primaryKey = 'id';
    public $timestamps = true;
    protected $fillable = [
        'title',
        'slug',
        'description',
        'text',
        'title_ru',
        'description_ru',
        'text_ru',
        'image',
        'clubs',
        'table_ratings_id',
        'created_at',
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

    /*
    |--------------------------------------------------------------------------
    | RELATIONS
    |--------------------------------------------------------------------------
    */

    public function table_ratings()
    {
        return $this->belongsTo('App\Models\Table_rating');
    }

    public function clubs()
    {
        return $this->belongsToMany('App\Models\Club');
    }

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

    public function getClubsAttribute()
    {
        $clubs = $this->clubs()->get();

        if(count($clubs)){
            $return = $clubs;
        } else {
            $return = Club::get();
        }

        return $return;
    }

    public function getTitleAttribute($value){
        return App::getLocale() == 'ru' && $this->title_ru || !$value ? $this->title_ru : $value;
    }

    public function getDescriptionAttribute($value){
        return App::getLocale() == 'ru' && $this->description_ru || !$value ? $this->description_ru : $value;
    }

    public function getTextAttribute($value){
        return App::getLocale() == 'ru' && $this->text_ru || !$value ? $this->text_ru : $value;
    }

    /*
	|--------------------------------------------------------------------------
	| MUTATORS
	|--------------------------------------------------------------------------
	*/

    public function setCreatedAtAttribute($value)
    {
        $this->attributes['created_at'] = $value ? new Carbon($value) : Carbon::now();
    }

    public function setImageAttribute($value)
    {
        $attribute_name = "image";
        $disk = "uploads";
        $destination_path = "admin/events";

        if ($value==null) {
            \Storage::disk($disk)->delete($this->image);
            $this->attributes[$attribute_name] = null;
        }

        if (starts_with($value, 'data:image'))
        {
            $image = \Image::make($value);
            $filename = md5($value.time()).'.jpg';
            \Storage::disk($disk)->put($destination_path.'/'.$filename, $image->stream());
            $image->fit(1140, 380, function ($constraint) {
                $constraint->aspectRatio();
                $constraint->upsize();
            })->save($disk.'/'.$destination_path.'/'.$filename, 60);
            $this->attributes[$attribute_name] = '/'.$disk.'/'.$destination_path.'/'.$filename;
        }
    }

}
