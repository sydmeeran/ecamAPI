<?php
//
//namespace App\Http\Controllers;
//
//use App\Repositories\DataRepo;
//use Arga\Utils\ActionMiddlewareTrait;
//use Illuminate\Http\Request;
//
//
//class JobEntryController extends BaseController
//{
//    use ActionMiddlewareTrait;
//
//    protected $job_entry;
//
//    public function __construct()
//    {
//        $this->job_entry = DataRepo::job_entry();
//        $this->actionMiddleware([
//            'register' => 'job-entry-create',
//            'update' => 'job-entry-update',
//            'getAll_pagination' => 'job-entry-retrieve',
//            'get' => 'job-entry-retrieve',
//            'search' => 'job-entry-retrieve',
//            'delete' => 'job-entry-delete'
//        ]);
//    }
//
//    /**
//     * Register api
//     *
//     * @param Request $request
//     * @return \Illuminate\Http\Response
//     */
//    public function register(Request $request)
//    {
//        if($this->check_api_key($request)){
//            return $this->job_entry->store($request);
//        }
//        return $this->unauthorized();
//    }
//
//    public function update(Request $request, $id)
//    {
//        if ($this->check_api_key($request)) {
//                return $this->job_entry->update($request, $id);
//        }
//        return $this->unauthorized();
//    }
//
//    public function getAll(Request $request)
//    {
//        if ($this->check_api_key($request)) {
//                $job_entries = $this->job_entry->with(['pnl_excel', 'balance_sheet_excel'])->toArray();
//                return $this->response($job_entries);
//
//        }
//        return $this->unauthorized();
//    }
//
//    public function getAll_pagination(Request $request)
//    {
//        if ($this->check_api_key($request)) {
//                $job_entry = $this->job_entry->model()->with('customer')->paginate(20);
//                return $this->response($job_entry);
//        }
//        return $this->unauthorized();
//    }
//
//    public function get(Request $request, $id)
//    {
//        if ($this->check_api_key($request)) {
//                $job_entry = $this->job_entry->with(['customer', 'pnl_excel', 'balance_sheet_excel'], $id)->toArray();
//                if(empty($job_entry)){
//                    return $this->empty_data();
//                }
//                $job_entry = $job_entry[0];
//                return $this->response($job_entry);
//        }
//        return $this->unauthorized();
//    }
//
//    public function search(Request $request){
//        if ($this->check_api_key($request)) {
//
//                $keyword = $request->get('keyword');
//            $result = $this->job_entry->model()
//                ->whereHas('customer', function($query) use ($keyword){
//                    $query->where('company_id', 'like', '%'.$keyword.'%')
//                        ->orWhere('company_name', 'like', '%'.$keyword.'%');
//                })
//                ->orWhere( 'type', 'LIKE', '%' . $keyword . '%' )
//                ->orWhere( 'company_type', 'LIKE', '%' . $keyword . '%' )
//                ->orWhere ( 'excel_type', 'LIKE', '%' . $keyword . '%' )
//                ->with(['customer'])->get();
//                return $this->response($result);
//        }
//        return $this->unauthorized();
//    }
//
//    public function delete(Request $request, $id){
//        if ($this->check_api_key($request)) {
//
//                $this->job_entry->destroy($id);
//                return $this->success();
//        }
//        return $this->unauthorized();
//    }
//}
