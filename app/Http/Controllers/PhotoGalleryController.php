<?php

namespace App\Http\Controllers;

use App\Models\Photo_gallery;
use App\Models\Video_gallery;
use Illuminate\Http\Request;

class PhotoGalleryController extends Controller
{
    public function index()
    {
        $PhotoGalleries = Photo_gallery::where('check_glob', '=', 1)->orderBy('id', 'desc')->paginate(999);
        $VideoGalleries = Video_gallery::where('check_glob', '=', 1)->orderBy('id', 'desc')->paginate(999);
        return view('gallery', [
            'PhotoGalleries' => $PhotoGalleries,
            'VideoGalleries' => $VideoGalleries
        ]);
    }

    public function show($slug)
    {
        $PhotoGallery = Photo_gallery::where('slug', $slug)->first();
        if(!$PhotoGallery) abort(404);

        // if($_SERVER['SERVER_ADDR'] == "172.31.45.69") {
            
        if($PhotoGallery->photos) {
            foreach ($PhotoGallery->photos as $key => $gallery) {
                if(isset($gallery) && $gallery) {
                    if(!file_exists(public_path("uploads/thumb/".$gallery))) {
                        $this->resizeImage($gallery);
                    }
                }
            } 
        }
        
        return view('gallery-photo', [
            'PhotoGallery' => $PhotoGallery,
        ]);
    }

    public function uploadPhoto(Request $request)
    {
        $gallery = new Photo_gallery();

        $data = $gallery->uploadPerFileToDisk($request->galleryId);
        
        if($data) {
        	$content = $data->getContent();
	        $array = json_decode($content, true);
	        $this->resizeImage($array['filename']);
        }
        return $data;        
    }


    public function resizeImage($dbPath) {
        
        try {
            $file = public_path('uploads/'.$dbPath);

            if (!is_file($file)) {
                return;
            }

            $source_properties = getimagesize($file);

            if ($source_properties === false) {
                return;
            }

            $image_type = $source_properties[2]; 

            if( $image_type == IMAGETYPE_JPEG ) {   
                $image_resource_id = imagecreatefromjpeg($file);  
            } elseif( $image_type == IMAGETYPE_GIF )  {  
                $image_resource_id = imagecreatefromgif($file); 
            } elseif( $image_type == IMAGETYPE_PNG ) {
                $image_resource_id = imagecreatefrompng($file); 
            }

            $target_width  = 360;
            $target_height = 230;
            $target_layer  = imagecreatetruecolor($target_width,$target_height);

            imagecopyresampled($target_layer,$image_resource_id,0,0,0,0,$target_width,$target_height, $source_properties[0], $source_properties[1]);

            $thumbnail = public_path('uploads/thumb/'.$dbPath);
            $thumbnailDirectory = dirname($thumbnail);

            if (!is_dir($thumbnailDirectory)) {
                mkdir($thumbnailDirectory, 0775, true);
            }

            imagejpeg($target_layer, $thumbnail);

        } catch (\Throwable $e) {
            
        }
    }
}
