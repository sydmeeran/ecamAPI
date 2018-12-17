<?php

namespace App\Http\Controllers;

use Arga\Storage\GoogleCloud\GoogleCloudClient;
use Illuminate\Http\Request;

class FileController extends Controller
{
    private $file;

    public function __construct()
    {
        $this->file = app(GoogleCloudClient::class);
    }

    /**
     * @param \Illuminate\Http\Request $request
     * @return array
     * @throws \Exception
     */
    public function store(Request $request)
    {
        return $this->file->uploadAndStoreFromContent($request->all());
    }
}
