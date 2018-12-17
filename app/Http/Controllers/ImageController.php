<?php

namespace App\Http\Controllers;

use Arga\Storage\Cloudinary\CloudinaryClient;
use Arga\Storage\Cloudinary\CloudinaryHelper;
use Arga\Storage\GoogleCloud\GoogleCloudClient;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;

class ImageController extends Controller
{
    use CloudinaryHelper;

    private $image;

    private $file;

    public function __construct()
    {
        $this->image = app(CloudinaryClient::class);
        $this->file = app(GoogleCloudClient::class);
    }

    /**
     * @param \Illuminate\Http\Request $request
     * @return \Arga\Storage\Cloudinary\Image
     * @throws \Exception
     */
    public function store(Request $request)
    {
        if ($file = $request->file('file')) {
            return $this->file->uploadAndStore($file);
            //putenv("GOOGLE_APPLICATION_CREDENTIALS=".storage_path('service-account-key.json'));
            //$client = new \Google_Client();
            //$client->useApplicationDefaultCredentials();
            //$client->addScope(\Google_Service_Storage::DEVSTORAGE_FULL_CONTROL);
            //
            //$filename = $file->getFilename().Carbon::now()->micro.".{$file->getExtension()}";
            //$disk = Storage::disk('gcs');
            //$status = $disk->put($filename, file_get_contents($file));
            //
            //$bucketName = 'layla-123.appspot.com';
            //$info = "https://storage.cloud.google.com/{$bucketName}/{$filename}";
            //
            //if ($info) {
            //    dd($info);
            //}
            //dd($status);
            //$result = $service->files->create(
            //    $file,
            //    [
            //        'data'     => file_get_contents($data),
            //        'mimeType' => $data->getMimeType(),
            //    ]
            //);
            //
            //dd($file);
            //
            //return $result;
            //$client->addScope(\Google_Service_Storage::DEVSTORAGE_FULL_CONTROL);

        }

        return $this->image->uploadFromContent($request->get('file'));
    }
}
