<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Backpack\CRUD\CrudTrait;
use Illuminate\Support\Facades\App;

class Video_gallery extends Model
{
    use CrudTrait;

     /*
    |--------------------------------------------------------------------------
    | GLOBAL VARIABLES
    |--------------------------------------------------------------------------
    */

    protected $table = 'video_galleries';
    protected $primaryKey = 'id';
    protected $fillable = [
         'title',
         'title_ru',
         'preview',
         'id_youtube',
         'club_id',
         'check_glob',
         'tournament_id',
         'created_at'
    ];

    public function club()
    {
        return $this->belongsTo('App\Models\Club');
    }
    public function tournament()
    {
        return $this->belongsTo('App\Models\Tournament');
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

    public function getTitleAttribute($value){
        return App::getLocale() == 'ru' && $this->title_ru || !$value ? $this->title_ru : $value;
    }

    /*
    |--------------------------------------------------------------------------
    | MUTATORS
    |--------------------------------------------------------------------------
    */
    public function setPreviewAttribute($value)
    {
        $attribute_name = "preview";
        $disk = "uploads";
        $destination_path = "admin/video";

        if ($value==null) {
            \Storage::disk($disk)->delete($this->image);
            $this->attributes[$attribute_name] = null;
        }

        if (starts_with($value, 'data:image'))
        {
            $image = \Image::make($value);
            $filename = md5($value.time()).'.jpg';
            \Storage::disk($disk)->put($destination_path.'/'.$filename, $image->stream());
            $image->resize(360, NULL, function ($constraint) {
                $constraint->aspectRatio();
                $constraint->upsize();
            })->save($disk.'/'.$destination_path.'/'.$filename, 60);
            $this->attributes[$attribute_name] = '/'.$disk.'/'.$destination_path.'/'.$filename;
        }
    }
}
