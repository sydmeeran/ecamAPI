<?php

namespace App\Repositories;

use App\SponsorDonate;
use Illuminate\Http\Request;

class SponsorDonateRepository extends BaseRepository
{

    public function model(){
        return SponsorDonate::query();
    }

    public function validation(Request $request)
    {
        return $request->validate([
            'company_name' => 'required|string',
            'email' => 'required|string',
            'phone_no' => 'required|string',
            'event_title' => 'required|string',
            'amount' => 'required|int',
            'description' => 'required|string',
            'type' => 'required|string',
        ]);
    }

    public function setData(Request $request)
    {
        return $request->only('company_name', 'email', 'phone_no',
             'event_title', 'amount', 'description', 'type');
    }

    public function store(Request $request){

        $this->validation($request);

        $data = $this->setData($request);

        $this->model()->create($data);

        return 'success';
    }

}