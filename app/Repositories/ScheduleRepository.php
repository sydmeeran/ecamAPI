<?php
/**
 * Created by PhpStorm.
 * User: damon
 * Date: 12/26/18
 * Time: 1:17 PM
 */

namespace App\Repositories;

use Illuminate\Http\Request;
use App\Schedule;
use Illuminate\Support\Facades\Validator;

class ScheduleRepository extends BaseRepository
{
    public function model(){
        return Schedule::query();
    }

    public function validation($data){
        return Validator::make($data, [
            'event' => 'required|string',
            'datetime' => 'required|string',
        ]);
    }

    public function setData(Request $request){
        $data = [
            'event' => $request->input('event'),
            'datetime' => $request->input('datetime'),
        ];
        return $data;
    }

    public function store(Request $request){

        $data = $this->setData($request);
        $validator = $this->validation($data);
        if($validator->fails()){
            return $validator;
        }
        $data['datetime'] = new \DateTime($data['datetime']);
        $data['user_id'] = auth()->id();

        $this->model()->create($data);

        return 'success';
    }

    public function update(Request $request, $id){
        $data = $this->setData($request);
        $validator = $this->validation($data);
        if($validator->fails()){
            return $validator;
        }
        $data['datetime'] = new \DateTime($data['datetime']);

        $this->model()->where('id', $id)->update($data);
        return 'success';
    }
}