<?php

namespace App\Http\Controllers;

use App\Business;
use App\Customer;
use App\Mail\CustomerVerificationEmail;

use App\Repositories\DataRepo;
use Illuminate\Http\Request;
use Illuminate\Http\UploadedFile;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Mail;
use Illuminate\Support\Facades\Validator;

class JobEntryController extends BaseController
{
    protected $job_entry;

    public function __construct()
    {
        $this->job_entry = DataRepo::job_entry();
    }

    /**
     * Register api
     *
     * @param Request $request
     * @return \Illuminate\Http\Response
     */
    public function register(Request $request)
    {
        $check = $this->check_api_auth($request, 'job-entry-create');
        if($check){
            return $this->job_entry->store($request);
        }
        return $check;
    }

    public function update(Request $request, $id)
    {
        if ($this->check_api_key($request)) {
            if ($this->check_permission('job-entry-update')) {

                $status = $this->job_entry->update($request, $id);

                if ($status === 'success') {
                    return $this->success();
                }

                return $this->errors($status);
            }
            return $this->permission_denied();
        }
        return $this->unauthorized();
    }

    public function getAll(Request $request)
    {
        if ($this->check_api_key($request)) {
            if($this->check_permission('job-entry-retrieve')){

                $job_entries = $this->job_entry->with(['pnl_excel', 'balance_sheet_excel'])->toArray();
                return $this->response($job_entries);
            }
            return $this->permission_denied();
        }
        return $this->unauthorized();
    }

    public function getAll_pagination(Request $request)
    {
        if ($this->check_api_key($request)) {
            if($this->check_permission('job-entry-retrieve')){
                $job_entry = $this->job_entry->model()->with('customer')->paginate(20);
                return $this->response($job_entry);
            }
            return $this->permission_denied();
        }
        return $this->unauthorized();
    }

    public function get(Request $request, $id)
    {
        if ($this->check_api_key($request)) {

            if($this->check_permission('job-entry-retrieve')){

                $job_entry = $this->job_entry->with(['customer', 'pnl_excel', 'balance_sheet_excel'], $id)->toArray();
                if(empty($job_entry)){
                    return $this->response($job_entry);
                }
                $job_entry = $job_entry[0];
                return $this->response($job_entry);
            }

            return $this->permission_denied();
        }
        return $this->unauthorized();
    }

    public function search(Request $request){
        if ($this->check_api_key($request)) {

            if($this->check_permission('job-entry-retrieve')){
                $keyword = $request->get('keyword');
                $result = $this->job_entry->model()->where( 'company_type', 'LIKE', '%' . $keyword . '%' )
                    ->orWhere ( 'excel_type', 'LIKE', '%' . $keyword . '%' )
                    ->orWhere ( 'excel_file', 'LIKE', '%' . $keyword . '%' )
                    ->with('customer')->get()->toArray();

                return $this->response($result);
            }

            return $this->permission_denied();
        }
        return $this->unauthorized();
    }

    public function delete(Request $request, $id){
        if ($this->check_api_key($request)) {

            if($this->check_permission('job-entry-delete')){
                $this->job_entry->destroy($id);
                return $this->success();
            }

            return $this->permission_denied();
        }
        return $this->unauthorized();
    }
}
