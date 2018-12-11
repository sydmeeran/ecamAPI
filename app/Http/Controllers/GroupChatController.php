<?php

namespace App\Http\Controllers;

use App\Repositories\DataRepo;
use Illuminate\Http\Request;

class GroupChatController extends Controller
{
    private $repo;

    public function __construct()
    {
        $this->repo = DataRepo::group_chat();
    }

    public function index()
    {
        $messages = $this->repo->get();

        return $messages;
    }

    protected function setData(Request $request)
    {
        $data = $request->only([
            'sender_id',
            'assigned_id',
        ]);

        $message = array_get($request->get('message'), 'message');
        $image = array_get($request->get('message'), 'image');

        $data = array_merge($data, [
            'message' => $message,
            'image'   => $image,
        ]);

        return $data;
    }

    /**
     * @param \Illuminate\Http\Request $request
     * @return \Illuminate\Contracts\Routing\ResponseFactory|\Illuminate\Http\Response
     * @throws \Illuminate\Validation\ValidationException
     */
    public function store(Request $request)
    {
        $data = $this->setData($request);

        $this->repo->store($data);

        return ok();
    }
}
