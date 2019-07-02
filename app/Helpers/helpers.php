<?php
/**
 * Created by PhpStorm.
 * User: damon
 * Date: 12/11/18
 * Time: 6:16 PM
 */
if (! function_exists('generateCode')) {
    /**
     * @param $permission
     * @return bool
     */
    function generateCode($length = 8) {
        $characters = '0123456789ABCDEFGHIJKLMNOPQRSTUVWXYZ';
        $charactersLength = strlen($characters);
        $randomString = '';
        for ($i = 0; $i < $length; $i++) {
            $randomString .= $characters[rand(0, $charactersLength - 1)];
        }
        return $randomString;
    }
}

if (! function_exists('generateNumber')) {
    /**
     * @param $permission
     * @return bool
     */
    function generateNumber($length = 8) {
        $characters = '0123456789';
        $charactersLength = strlen($characters);
        $randomString = '';
        for ($i = 0; $i < $length; $i++) {
            $randomString .= $characters[rand(0, $charactersLength - 1)];
        }
        return $randomString;
    }
}

if ( ! function_exists('get_image'))
{
    function get_image($image)
    {
        if(strpos($image, 'ecam/') !== false){
            return Cloudder::show($image);
        }
        return env('API_URL').'/'.$image;   
    }
}

if ( ! function_exists('delete_image'))
{
    function delete_image($image)
    {
        if($image){
            if(strpos($image, 'ecam/') !== false){
                return Cloudder::delete($image);
            } else {
                if(file_exists($image)){
                    unlink($image);
                }
            }
        }
    }
}

if ( ! function_exists('image_name'))
{
    function image_name($type = null, $sub_type = null)
    {
        return date('Y-m-d_H-i-ss').'_'.$type.'_'.$sub_type.'_'.generateCode().'.jpg';
    }
}