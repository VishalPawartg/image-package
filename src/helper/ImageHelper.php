<?php
namespace VishalPawar\ImageConvert;

use Illuminate\Support\Facades\Storage;
use Intervention\Image\ImageManagerStatic as Images;

class ImageHelper{
    /**
     * To save the image in the Object Storage
     *
     * @param [String] $path
     * @param Images $uploadedImage
     * @param [String] $unique_name
     * @return void
     */
    public static function saveImage($path , $image , $objectStore )
    {
        return config('ImageConvert.aws_path');
        // return "bye world";
        try{
            if($objectStore){

                $url = Storage::disk('do_spaces')->putFile($path , $image , 'public');

                return config('ImageConvert.do_spaces.originendpoint').$url;

            }else{
                if (!is_dir($path)) {
                    //Directory does not exist, so lets create it.
                    mkdir($path, 0755, true);
                }
    
                $imageStoreName = str_replace(' ','',$image->getClientOriginalName());
    
                $image = Images::make($image->getRealPath());
    
                $image->save(public_path($path . $imageStoreName));
    
                return $path.$imageStoreName;

            }

        }catch(\Exception $e){
            \Log::error($e->getMessage());
            return $e->getMessage();
        }
    }

    /**
     * To resize and save the image in the object storage
     *
     * @param [type] $path
     * @param [type] $image
     * @param [type] $unique_name
     * @param [type] $height
     * @param [type] $width
     * @return void
     */
    public static function resizeSaveImage($path, $image, $height, $width)
    {
        try{
            if (!is_dir($path)) {
                //Directory does not exist, so lets create it.
                mkdir($path, 0755, true);
            }
        $imageStoreName = str_replace(' ','',$image->getClientOriginalName());
        //save mobile list image
        $image = Images::make($image->getRealPath());
        $image->resize($height , $width);
        $image->save(public_path($path . $imageStoreName));

        return $path.$imageStoreName;

        }catch(\Exception $e){
            \Log::error($e->getMessage());

        }
    }

    /**
     * To save the webp image in the Object Storage
     *
     * @param [type] $path
     * @param [type] $image
     * @param [type] $unique_name
     * @return void
     */
    public static function saveWebpImage($path , $image )
    {
    try{ 
        if (!is_dir($path)) {
            //Directory does not exist, so lets create it.
            mkdir($path, 0755, true);
        }

        $imageStoreName  = pathinfo(str_replace(' ', '', $image->getClientOriginalName()), PATHINFO_FILENAME).'.'.'webp';

        //save mobile list image webp
        $saveImage = Images::make($image);
        $saveImage->encode('webp');
        $saveImage->save(public_path($path . $imageStoreName));
        
        return $path.$imageStoreName;

    }catch(\Exception $e){
        \Log::error($e->getMessage());

    }
    }

    /**
     * To Resize, Convert and Save the webp image in the Object Storage
     *
     * @param [type] $path
     * @param [type] $image
     * @param [type] $unique_name
     * @param [type] $dimensionFirst
     * @param [type] $dimensionSecond
     * @return void
     */
    public static function resizeSaveWebpImage($path , $image , $height, $width)
    {
    try{ 
        if (!is_dir($path)) {
            //Directory does not exist, so lets create it.
            mkdir($path, 0755, true);
        }

        $imageStoreName  =  pathinfo(str_replace(' ', '', $image->getClientOriginalName()), PATHINFO_FILENAME).'.'.'webp';

        //save mobile list image webp
        $imageStore = Images::make($image);
        $imageStore->encode('webp')->resize($height, $width);
        $imageStore->save(public_path($path . $imageStoreName));
        
        return $path.$imageStoreName;

    }catch(\Exception $e){
        \Log::error($e->getMessage());

    }
    }

    public static function base64_to_jpeg($base64_string) {
        
        $data = explode( ',', $base64_string );

        return  $image = Images::make(base64_decode($data[1])) ;

    }
}
?>