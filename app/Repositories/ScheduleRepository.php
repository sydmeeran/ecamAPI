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

    public function update($excel_file, $job_entry_id){
        $data = $this->setData($excel_file, $job_entry_id);
        $validator = $this->validation($data);
        if($validator->fails()){
            if(file_exists($excel_file)){
                unlink($excel_file);
            }
            return $validator;
        }
        $this->model()->where('job_entry_id', $job_entry_id)->update($data);
        return 'success';
    }
}