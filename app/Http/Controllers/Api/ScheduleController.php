<?php

namespace App\Http\Controllers\Api;

use App\Repositories\DataRepo;
use Arga\Utils\ActionMiddlewareTrait;
use Illuminate\Http\Request;

class ScheduleController extends BaseController
{
    use ActionMiddlewareTrait;

    protected $schedule;

    public function __construct(){

        $this->schedule = DataRepo::schedule();


        $this->actionMiddleware([
            'delete' => 'schedule-delete',
        ]);
    }

    public function getAll(Request $request){
        if ($this->check_api_key($request)) {
            $schedules = $this->schedule->getAll();
            return $this->response($schedules);
        }
        return response()->json($this->unauthorized);
    }

    public function get(Request $request, $id){
        if ($this->check_api_key($request)) {
            $schedule = $this->schedule->with(['user'], $id)->toArray();
            if(empty($schedule)){
                return $this->empty_data();
            }
            $schedule = $schedule[0];
            return $this->response($schedule);
        }
        return $this->unauthorized();
    }

    public function store(Request $request){
        if ($this->check_api_key($request)) {
            return $this->schedule->store($request);
        }
        return $this->unauthorized();
    }

    public function update(Request $request, $id){
        if ($this->check_api_key($request)) {
            return $this->schedule->update($request, $id);
        }
        return $this->unauthorized();
    }

    public function delete(Request $request, $id){
        if ($this->check_api_key($request)) {
            $this->schedule->delete($id);
            return $this->success();
        }
        return $this->unauthorized();
    }


}
