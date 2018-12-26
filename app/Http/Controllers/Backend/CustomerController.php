<?php

namespace App\Http\Controllers\Backend;

use App\Repositories\DataRepo;
use Illuminate\Http\Request;
use App\Http\Controllers\BaseController;

class CustomerController extends BaseController
{
    protected $repo;

    public function __construct(){
        $this->repo = DataRepo::customer();
    }

    public function verify(Request $request)
    {
        if ($this->check_api_key($request)) {
            $email = $request->input('email');
            $otp = $request->input('otp');

            $this->repo->model()->where('email', $email)->where('otp', $otp)->update([
                'is_active' => 1
            ]);

            return 'success';
        }
        return $this->unauthorized();
    }
}
