<?php

namespace App\Http\Controllers\Api;

use App\Repositories\DataRepo;
use Arga\Utils\ActionMiddlewareTrait;
use Illuminate\Http\Request;

class JobEntryController extends BaseController
{
    use ActionMiddlewareTrait;

    protected $job_entry;

    public function __construct()
    {
        $this->actionMiddleware([
            'store' => 'job-entry-create',
            'update' => 'job-entry-update',
            'pagination' => 'job-entry-retrieve',
            'get' => 'job-entry-retrieve',
            'search' => 'job-entry-retrieve',
            'delete' => 'job-entry-delete'
        ]);

        $this->job_entry = DataRepo::job_entry();
    }

    /**
     * Register api
     *
     * @param Request $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        return $this->job_entry->store($request);
    }

    public function update(Request $request, $id)
    {
        return $this->job_entry->update($request, $id);
    }

    public function getAll()
    {
        $job_entries = $this->job_entry->with(['pnl_excel', 'balance_sheet_excel'])->toArray();
        return $this->response($job_entries);
    }

    public function pagination()
    {
        $job_entry = $this->job_entry->model()->with('member')->paginate(20);
        return $this->response($job_entry);
    }

    public function get($id)
    {
        $job_entry = $this->job_entry->with(['member', 'pnl_excel_data', 'balance_sheet_excel'], $id)->toArray();
        if (empty($job_entry)) {
            return $this->empty_data();
        }
        $job_entry = $job_entry[0];
        return $this->response($job_entry);
    }

    public function search(Request $request)
    {
        $keyword = $request->get('keyword');
        $result = $this->job_entry->model()
            ->whereHas('member', function ($query) use ($keyword) {
                $query->where('company_id', 'like', '%' . $keyword . '%')
                    ->orWhere('company_name', 'like', '%' . $keyword . '%');
            })
            ->orWhere('type', 'LIKE', '%' . $keyword . '%')
            ->orWhere('company_type', 'LIKE', '%' . $keyword . '%')
            ->orWhere('excel_type', 'LIKE', '%' . $keyword . '%')
            ->with(['member'])->get();
        return $this->response($result);
    }

    public function delete($id)
    {
        $this->job_entry->destroy($id);
        return $this->success();
    }
}
