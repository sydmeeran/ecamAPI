<?php

namespace App\Http\Controllers\Api;

use Illuminate\Http\Request;
use App\Repositories\DataRepo;
use Arga\Utils\ActionMiddlewareTrait;

class SponsorDonateController extends BaseController
{
    use ActionMiddlewareTrait;

    protected $sponsor_donate;

    public function __construct()
    {
        $this->actionMiddleware([
            'pagination' => 'invoice-retrieve',
            'get' => 'invoice-retrieve',
            'store' => 'invoice-create',
        ]);

        $this->sponsor_donate = DataRepo::sponsor_donate();
    }

    public function pagination()
    {
        $sponsor_donate = $this->sponsor_donate->model()->paginate(20);
        return $this->response($sponsor_donate);
    }

    public function get($id)
    {
        $sponsor_donate = $this->sponsor_donate->find($id)->toArray();
        if (empty($sponsor_donate)) {
            return $this->empty_data();
        }
        // $sponsor_donate = $sponsor_donate[0];
        return $this->response($sponsor_donate);
    }

    public function store(Request $request)
    {
        return $this->sponsor_donate->store($request);
    }
}
