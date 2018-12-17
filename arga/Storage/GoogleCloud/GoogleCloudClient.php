<?php
/**
 * Created by PhpStorm.
 * User: naingminkhant
 * Date: 12/17/18
 * Time: 12:16 PM
 */

namespace Arga\Storage\GoogleCloud;

use Carbon\Carbon;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Http\UploadedFile;
use Illuminate\Support\Facades\Storage;

class GoogleCloudClient
{
    /**
     * @var array
     */
    private $config;

    const GOOGLE_BUCKET = 'google_bucket';

    public function __construct($config)
    {
        $this->config = $config;
        $this->createGoogleClient();
    }

    protected function createGoogleClient()
    {
        putenv("GOOGLE_APPLICATION_CREDENTIALS=".$this->config['key_file']);
        $client = new \Google_Client();
        $client->useApplicationDefaultCredentials();
        $client->addScope(\Google_Service_Storage::DEVSTORAGE_FULL_CONTROL);

        return $client;
    }

    /**
     * @param \Illuminate\Http\UploadedFile $file
     * @return array
     * @throws \Exception
     */
    public function uploadAndStore(UploadedFile $file)
    {
        $saveFile = $this->upload($file);
        $url = $this->getFileUrl($saveFile);

        return $this->store([
            'name' => $saveFile,
            'url'  => $url,
        ]);
    }

    /**
     * @param array $attribute
     * @return array
     * @throws \Exception
     */
    public function uploadAndStoreFromContent(array $attribute)
    {
        $saveFile = $this->uploadFromContent($attribute);
        $url = $this->getFileUrl($saveFile);

        return $this->store([
            'name' => $saveFile,
            'path' => $url,
        ]);
    }

    protected function store(array $attribute)
    {
        /** @var \Arga\Storage\GoogleCloud\File $file */
        $file = File::create([
            'name'          => array_get($attribute, 'name'),
            'cloud_service' => self::GOOGLE_BUCKET,
            'path'          => array_get($attribute, 'path'),
        ]);

        return $file->toAll();
    }

    /**
     * @param \Illuminate\Http\UploadedFile $file
     * @return string
     * @throws \Exception
     */
    protected function upload(UploadedFile $file)
    {
        $filename = $this->generateFileName($file);
        $disk = Storage::disk('gcs');
        $status = $disk->put($filename, file_get_contents($file));

        if (!$status) {
            throw new \Exception("Internal Server Error");
        }

        return $filename;
    }

    /**
     * @param array $attribute
     * @return mixed
     * @throws \Exception
     */
    protected function uploadFromContent(array $attribute)
    {
        $disk = Storage::disk('gcs');
        $status = $disk->put(array_get($attribute, 'name'), base64_decode(array_get($attribute, 'content')));
        if (!$status) {
            throw new \Exception("Internal Server Error");
        }

        return $attribute['name'];
    }

    protected function getFileUrl($filename)
    {
        return $url = "https://storage.cloud.google.com/{$this->config['bucket']}/{$filename}";
    }

    protected function generateFileName(UploadedFile $file)
    {
        $extension = $file->extension();
        $name = $file->getFilename();
        $time = Carbon::now()->micro;

        return $filename = "{$name}{$time}.{$extension}";
    }

    public function destroy($id)
    {
        return File::destroy($id);
    }

    public function attach($id, Model $model)
    {
        $file = File::find($id);
        if($file instanceof File) {
            $file->related_model()->associate($model);
            $file->update();
        }
    }
}
