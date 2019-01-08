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
use Illuminate\Validation\ValidationException;

class ScheduleRepository extends BaseRepository
{
    public function model(){
        return Schedule::query();
    }

    public function validation($data){
        return Validator::make($data, [
            'title' => 'required|string',
            'from' => 'required|string',
            'to' => 'required|string',
            'description' => 'required|string',
        ]);
    }

    public function setData(Request $request){
        $data = [
            'title' => $request->input('title'),
            'from' => $request->input('from'),
            'to' => $request->input('to'),
            'description' => $request->input('description'),
        ];
        return $data;
    }

    public function store(Request $request){

        $data = $this->setData($request);
        $validator = $this->validation($data);
        if($validator->fails()){
            throw new ValidationException($validator);
        }
        $data['from'] = new \DateTime($data['from']);
        $data['to'] = new \DateTime($data['to']);
        $data['user_id'] = auth()->id();

        $this->model()->create($data);

        return 'success';
    }

    public function update(Request $request, $id){
        $data = $this->setData($request);
        $validator = $this->validation($data);
        if($validator->fails()){
            throw new ValidationException($validator);
        }
        $data['from'] = new \DateTime($data['from']);
        $data['to'] = new \DateTime($data['to']);

        $this->model()->where('id', $id)->update($data);
        return 'success';
    }
}