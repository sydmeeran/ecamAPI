<?php

namespace App\Http\Controllers;

use Arga\Storage\Cloudinary\CloudinaryClient;
use Arga\Storage\Cloudinary\CloudinaryHelper;
use Illuminate\Http\Request;

class ImageController extends Controller
{
    use CloudinaryHelper;

    private $image;

    public function __construct()
    {
        $this->image = app(CloudinaryClient::class);
    }

    /**
     * @param \Illuminate\Http\Request $request
     * @return \Arga\Storage\Cloudinary\Image
     * @throws \Exception
     */
    public function store(Request $request)
    {
        return $this->image->uploadFromContent($request->get('image'));
    }
}
