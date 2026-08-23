<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Backpack\CRUD\CrudTrait;
use Cviebrock\EloquentSluggable\Sluggable;
use Cviebrock\EloquentSluggable\SluggableScopeHelpers;
use Illuminate\Support\Facades\App;
use Illuminate\Support\Facades\DB;

class Photo_gallery extends Model
{
    use CrudTrait;
    use Sluggable;
    use SluggableScopeHelpers;

     /*
	|--------------------------------------------------------------------------
	| GLOBAL VARIABLES
	|--------------------------------------------------------------------------
	*/

    protected $table = 'photo_galleries';
    protected $primaryKey = 'id';
    protected $fillable = [
        'title',
        'title_ru',
        'slug',
        'preview',
        'photos',
        'club_id',
        'check_glob',
        'tournament_id',
        'created_at'
    ];

    protected $casts = [
        'photos' => 'array'
    ];

    /*
	|--------------------------------------------------------------------------
	| FUNCTIONS
	|--------------------------------------------------------------------------
	*/

    public function sluggable()
    {
        return [
            'slug' => [
                'source' => 'slug_or_title',
            ],
        ];
    }

    public function uploadMultipleFilesToDisk($value, $attribute_name, $disk, $destination_path)
    {
        $request = \Request::instance();
        $attribute_value = (array) $this->{$attribute_name};
        $files_to_clear = $request->get('clear_'.$attribute_name);

        if ($files_to_clear) {
            $attribute_value = (array) $this->{$attribute_name};
            foreach ($files_to_clear as $key => $filename) {
                \Storage::disk($disk)->delete($filename);
                $attribute_value = array_where($attribute_value, function ($value, $key) use ($filename) {
                    return $value != $filename;
                });
            }
        }

        if ($request->hasFile($attribute_name)) {
            foreach ($request->file($attribute_name) as $file) {
                if ($file->isValid()) {
                    $new_file_name = md5($file->getClientOriginalName().time()).'.'.$file->getClientOriginalExtension();
                    $file_path = $file->storeAs($destination_path, $new_file_name, $disk);
                    $attribute_value[] = $file_path;

                    $image = \Image::make($disk.'/'.$file_path);
                    $image->resize(1920, NULL, function ($constraint) {
                        $constraint->aspectRatio();
                        $constraint->upsize();
                    })->save($disk.'/'.$file_path, 60);
                }
            }
        }

        $this->attributes[$attribute_name] = json_encode($attribute_value);
    }

    public function uploadPerFileToDisk($galleryId)
    {
        ini_set('memory_limit','512M');
        $attribute_name = "photos";
        $disk = "uploads";
        $destination_path = "admin/photos";
        $request = \Request::instance();
        $attribute_value = array();
        $gallery = DB::table('photo_galleries')->where('id',$galleryId)->first();
        if(!empty($gallery))
        {
            $photos = json_decode($gallery->photos, true);
            $file = $request->file('file');
            if ($file->isValid()) {
                $new_file_name = md5($file->getClientOriginalName().time()).'.'.$file->getClientOriginalExtension();
                $file_path = $file->storeAs($destination_path, $new_file_name, $disk);
                $photos[] = $file_path;
                $image = \Image::make($disk.'/'.$file_path);
                $image->resize(1920, NULL, function ($constraint) {
                    $constraint->aspectRatio();
                    $constraint->upsize();
                })->save($disk.'/'.$file_path, 60);
                $count = count($photos);
                $photos = json_encode($photos);

                DB::table('photo_galleries')->where('id', $galleryId)->update(['photos' => $photos]);

                return response()->json([
                    'status' => 'success',
                    'filename' => $file_path,
                    'photo_key' => $count
                ]);
            }
            else{
                return response()->json([
                    'status' => 'error',
                    'message' => 'File is not valid',
                ]);
            }
        }



    }

    /*
	|--------------------------------------------------------------------------
	| RELATIONS
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
        ini_set('memory_limit','512M');
        $attribute_name = "preview";
        $disk = "uploads";
        $destination_path = "admin/photos";

        if ($value==null) {
            \Storage::disk($disk)->delete($this->image);
            $this->attributes[$attribute_name] = null;
        }

        if (starts_with($value, 'data:image'))
        {
            $image = \Image::make($value);
            $filename = md5($value.time()).'.jpg';
            \Storage::disk($disk)->put($destination_path.'/'.$filename, $image->stream());
            $image->resize(NULL, 240, function ($constraint) {
                $constraint->aspectRatio();
            })->save($disk.'/'.$destination_path.'/'.$filename, 60);
            $this->attributes[$attribute_name] = '/'.$disk.'/'.$destination_path.'/'.$filename;
        }
    }

    public function setPhotosAttribute($value)
    {
        ini_set('memory_limit','512M');
        $attribute_name = "photos";
        $disk = "uploads";
        $destination_path = "admin/photos";

        $this->uploadMultipleFilesToDisk($value, $attribute_name, $disk, $destination_path);
    }
}
