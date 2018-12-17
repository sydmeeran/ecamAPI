<?php
/**
 * Created by PhpStorm.
 * User: naingminkhant
 * Date: 12/17/18
 * Time: 12:58 PM
 */

namespace Arga\Storage\GoogleCloud;

use Illuminate\Http\UploadedFile;

class GoogleCloudClientHelper
{
    /**
     * @param \Illuminate\Http\UploadedFile $file
     * @return \Arga\Storage\GoogleCloud\File
     * @throws \Exception
     */
    public function uploadFile(UploadedFile $file): File
    {
        $client = app(GoogleCloudClient::class);
        $info = $client->uploadAndStore($file);

        return $info;
    }

    public function destroyFile($id)
    {
        $client = app(GoogleCloudClient::class);

        return $client->destroy($id);
    }

}
