<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Backpack\CRUD\CrudTrait;
use Illuminate\Support\Facades\App;

class Slide extends Model
{
    use CrudTrait;

     /*
	|--------------------------------------------------------------------------
	| GLOBAL VARIABLES
	|--------------------------------------------------------------------------
	*/

    protected $table = 'slides';
    protected $primaryKey = 'id';
     protected $fillable = [
         'title',
         'description',
         'btn_text',
         'btn_link',
         'image',
         'title_ru',
         'description_ru',
         'btn_text_ru',
         'btn_link_ru',
     ];

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
    public function getDescriptionAttribute($value){
        return App::getLocale() == 'ru' && $this->description_ru || !$value ? $this->description_ru : $value;
    }
    public function getBtnTextAttribute($value){
        return App::getLocale() == 'ru' && $this->btn_text_ru || !$value ? $this->btn_text_ru : $value;
    }
    public function getBtnLinkAttribute($value){
        return App::getLocale() == 'ru' && $this->btn_link_ru || !$value ? $this->btn_link_ru : $value;
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
        $destination_path = "admin/slider";

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
