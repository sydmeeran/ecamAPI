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
        $characters = '0123456789abcdefghijklmnopqrstuvwxyzABCDEFGHIJKLMNOPQRSTUVWXYZ';
        $charactersLength = strlen($characters);
        $randomString = '';
        for ($i = 0; $i < $length; $i++) {
            $randomString .= $characters[rand(0, $charactersLength - 1)];
        }
        return $randomString;
    }
}