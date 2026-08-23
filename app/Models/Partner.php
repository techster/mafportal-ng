<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Backpack\CRUD\CrudTrait;

class Partner extends Model
{
    use CrudTrait;

     /*
	|--------------------------------------------------------------------------
	| GLOBAL VARIABLES
	|--------------------------------------------------------------------------
	*/

    protected $table = 'partners';
    protected $primaryKey = 'id';
    protected $fillable = [
         'name',
         'logo',
         'link'
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

    /*
	|--------------------------------------------------------------------------
	| MUTATORS
	|--------------------------------------------------------------------------
	*/
    public function setLogoAttribute($value)
    {
        $attribute_name = "logo";
        $disk = "uploads";
        $destination_path = "admin/partners";

        if (starts_with($value, 'data:image'))
        {
            $image = \Image::make($value);
            $filename = md5($value.time()).'.jpg';
            \Storage::disk($disk)->put($destination_path.'/'.$filename, $image->stream());
            $image->resize(NULL, 100, function ($constraint) {
                $constraint->aspectRatio();
                $constraint->upsize();
            })->save($disk.'/'.$destination_path.'/'.$filename, 60);
            $this->attributes[$attribute_name] = $disk.'/'.$destination_path.'/'.$filename;
        }
    }
}
