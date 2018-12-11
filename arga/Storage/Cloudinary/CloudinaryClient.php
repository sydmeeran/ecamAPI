<?php

namespace Arga\Storage\Cloudinary;

use Cloudinary\Uploader;
use Illuminate\Database\Eloquent\Model;
use Symfony\Component\HttpFoundation\File\UploadedFile;

/**
 * @method configure(array $array)
 */
class CloudinaryClient
{
    protected $cloud_name;

    protected $api_key;

    protected $api_secret;

    protected $path;

    const CLOUDINARY = 'cloudinary';

    public function __construct($config)
    {
        $this->cloud_name = $config['cloud_name'];
        $this->api_key = $config['api_key'];
        $this->api_secret = $config['api_secret'];
        $this->path = env('IMAGE_PATH');

        $this->configuration($config);
    }

    /**
     * @param string $preset
     */
    public function setUploadPreset($preset)
    {
        $this->configure(['upload_preset' => $preset]);
    }

    protected function configuration($config)
    {
        \Cloudinary::config($config);
    }

    public function uploadAndAttachFromUrl(Model $model, $fileUrl)
    {
        $saveFile = $this->uploadFromUrl($fileUrl);
        $saveFile->related_model()->associate($model);
        $saveFile->save();

        return $saveFile->fresh();
    }

    public function uploadFromUrl($fileUrl, $folder = 'images/', $options = [])
    {
        if (!$fileUrl) {
            return null;
        }

        $cloudInfo = $this->saveToCloudFromUrl($fileUrl, $folder);

        return $this->store($cloudInfo);
    }

    protected function store(array $attribute)
    {
        $model = Image::create([
            'name'          => str_random(10),
            'cloud_service' => self::CLOUDINARY,
            'path'          => array_get($attribute, 'public_id'),

        ]);

        /**
         * @var \Arga\Storage\Cloudinary\Image $model
         */
        return $model->toAll();
    }

    public function uploadFromContent($content, $folder = 'images/')
    {
        if (!$content) {
            return null;
        }

        $cloudInfo = $this->saveToCloudFromContent($content, $folder);

        return $this->store($cloudInfo);
    }

    /**
     * @param \Illuminate\Database\Eloquent\Model $model
     * @param \Symfony\Component\HttpFoundation\File\UploadedFile $file
     * @return \Arga\Storage\Cloudinary\Image|null
     * @throws \Exception
     */
    public function uploadAndAttach(Model $model, UploadedFile $file)
    {
        $saveFile = $this->upload($file);
        $saveFile->related_model()->associate($model);
        $saveFile->save();

        return $saveFile->fresh();
    }

    /**
     * @param \Symfony\Component\HttpFoundation\File\UploadedFile $file
     * @param string $folder
     * @param array $options
     * @return \Arga\Storage\Cloudinary\Image
     * @throws \Exception
     */
    public function upload(UploadedFile $file, $folder = 'images/', $options = [])
    {
        $extension = $file->guessClientExtension();
        if (!$extension) {
            throw new \Exception("Unsupported File.");
        }

        $cloudInfo = $this->saveToCloud($file, $folder);

        return $this->store($cloudInfo);
    }

    public function saveToCloud(UploadedFile $file, $folder)
    {
        return Uploader::upload($file->getRealPath(), [
            'folder' => $folder,
        ]);
    }

    public function saveToCloudFromUrl($file, $folder)
    {
        return Uploader::upload($file, [
            'folder' => $folder,
        ]);
    }

    public function saveToCloudFromContent($file, $folder)
    {
        return Uploader::upload("data:image/png;base64,{$file}", [
            'folder' => $folder,
        ]);
    }

    /**
     * @param $id (id accept array or string)
     * @param \Illuminate\Database\Eloquent\Model $model
     */
    public function update($id, Model $model)
    {
        if (is_array($id)) {
            foreach ($id as $value) {
                $file = Image::findOrFail($value);
                if ($file instanceof Image) {
                    $file->related_model()->associate($model);
                    $file->update();
                }
            }

            return;
        }

        $file = Image::findOrFial($id);
        if ($file instanceof Image) {
            $file->related_model()->associate($model);
            $file->update();
        }
    }

    /**
     * @param $id
     * @return boolean
     */
    public function destroy($id)
    {
        $file = Image::find($id)->delete();

        return $file;
    }
}
