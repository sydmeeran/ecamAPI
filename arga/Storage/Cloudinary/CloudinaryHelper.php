<?php

namespace Arga\Storage\Cloudinary;

use Symfony\Component\HttpFoundation\File\UploadedFile;

trait CloudinaryHelper
{
    /**
     * @param \Symfony\Component\HttpFoundation\File\UploadedFile $file
     * @return \Arga\Storage\Cloudinary\Image
     * @throws \Exception
     */
    public function uploadFile(UploadedFile $file): Image
    {
        /** @var CloudinaryClient $fileUploader */
        $fileUploader = app(CloudinaryClient::class);
        $info = $fileUploader->upload($file);

        return $info;
    }

    /**
     * @param array $files
     * @return array
     * @throws \Exception
     */
    public function multiUploadFile(array $files): array
    {
        $info = [];
        /** @var CloudinaryClient $fileUploader */
        $fileUploader = app(CloudinaryClient::class);
        foreach ($files as $file) {
            if ($file instanceof UploadedFile) {
                $info[] = $fileUploader->upload($file);
            }
        }

        return $info;
    }

    public function destroyFile($id)
    {
        $client = app(CloudinaryClient::class);

        return $client->destroy($id);
    }
}
