<?php

namespace App\Http\Controllers\Api;

use App\Repositories\DataRepo;
use Arga\Utils\ActionMiddlewareTrait;
use Illuminate\Http\Request;

class ScheduleController extends BaseController
{
    use ActionMiddlewareTrait;

    protected $schedule;

    public function __construct()
    {
        $this->actionMiddleware([
            'delete' => 'schedule-delete',
        ]);

        $this->schedule = DataRepo::schedule();
    }

    public function getAll()
    {
        $schedules = $this->schedule->getAll();
        return $this->response($schedules);
    }

    public function get($id)
    {
        $schedule = $this->schedule->with(['user'], $id)->toArray();
        if (empty($schedule)) {
            return $this->empty_data();
        }
        $schedule = $schedule[0];
        return $this->response($schedule);
    }

    public function store(Request $request)
    {
        return $this->schedule->store($request);

    }

    public function update(Request $request, $id)
    {
        return $this->schedule->update($request, $id);
    }

    public function delete($id)
    {
        $this->schedule->delete($id);
        return $this->success();
    }


}
