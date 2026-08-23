<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Backpack\CRUD\CrudTrait;
use Cviebrock\EloquentSluggable\Sluggable;
use Cviebrock\EloquentSluggable\SluggableScopeHelpers;
use Illuminate\Support\Facades\App;

class Club extends Model
{
    use CrudTrait;
    use Sluggable;
    use SluggableScopeHelpers;

     /*
	|--------------------------------------------------------------------------
	| GLOBAL VARIABLES
	|--------------------------------------------------------------------------
	*/

    public function country()
    {
        return $this->hasOne('App\Country');
    }

    protected $table = 'clubs';
    protected $primaryKey = 'id';
    // public $timestamps = false;
    // protected $guarded = ['id'];
     protected $fillable = [
         'title',
         'slug',
         'city',
         'country_id',
         'image',
         'description',
         'text',
         'text_ru',
         'table_ratings_id',
         'private',
         'meta_title',
         'meta_description',
         'meta_title_ru',
         'meta_description_ru'
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

    public function game_ratings()
    {
        return $this->hasMany('App\Models\Game_rating');
    }

    public function users()
    {
        return $this->belongsToMany('App\User')->withPivot('confirm', 'active', 'admin');
    }

    public function seasons()
    {
        return $this->belongsTo('App\Models\Season');
    }

    public function users_admin()
    {
        return $this->belongsToMany('App\User')
            ->withPivot('confirm', 'active', 'admin')
            ->wherePivot('admin', 1);
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

    public function getTextAttribute($value){
        return App::getLocale() == 'ru' && $this->text_ru || !$value ? $this->text_ru : $value;
    }

    /*
	|--------------------------------------------------------------------------
	| MUTATORS
	|--------------------------------------------------------------------------
	*/
    public function setImageAttribute($value)
    {
        $attribute_name = "image";
        $disk = "uploads";
        $destination_path = "admin/clubs";

        if ($value==null) {
            \Storage::disk($disk)->delete($this->image);
            $this->attributes[$attribute_name] = null;
        }

        if (starts_with($value, 'data:image'))
        {
            $image = \Image::make($value);
            $filename = md5($value.time()).'.jpg';
            \Storage::disk($disk)->put($destination_path.'/'.$filename, $image->stream());

            $width = 1920;
            $height = 450;
            $image->width() > $image->height() * ($width / $height) ? $width=null : $height=null;
            if($image->width() > $width && $image->height() > $height){
                $image->resize($width, $height, function ($constraint) {
                    $constraint->aspectRatio();
                    $constraint->upsize();
                })->save($disk.'/'.$destination_path.'/'.$filename, 60);
            }

            $this->attributes[$attribute_name] = '/'.$disk.'/'.$destination_path.'/'.$filename;
        }
    }
}
