<?php
//
//namespace App\Http\Controllers;
//
//use App\Repositories\DataRepo;
//use Arga\Utils\ActionMiddlewareTrait;
//use Illuminate\Http\Request;
//
//class ScheduleController extends BaseController
//{
//    use ActionMiddlewareTrait;
//
//    protected $schedule;
//
//    public function __construct(){
//
//        $this->schedule = DataRepo::schedule();
//
//        $this->actionMiddleware([
//            'delete' => 'schedule-delete',
//        ]);
//    }
//
//    public function pagination(Request $request)
//    {
//        if ($this->check_api_key($request)) {
//            $invoice = $this->invoice->model()->with('customer')->with('business')->with('receipt')->paginate(20);
//            return $this->response($invoice);
//        }
//        return $this->unauthorized();
//    }
//
//    public function get(Request $request, $id){
//        if ($this->check_api_key($request)) {
//            $schedule = $this->schedule->with(['user'], $id)->toArray();
//            if(empty($schedule)){
//                return $this->empty_data();
//            }
//            $schedule = $schedule[0];
//            return $this->response($schedule);
//        }
//        return $this->unauthorized();
//    }
//
//    public function store(Request $request){
//        if ($this->check_api_key($request)) {
//            return $this->schedule->store($request);
//        }
//        return $this->unauthorized();
//    }
//
//    public function update(Request $request, $id){
//        if ($this->check_api_key($request)) {
//            return $this->schedule->update($request, $id);
//        }
//        return $this->unauthorized();
//    }
//
////
////
////    public function search(Request $request){
////        if ($this->check_api_key($request)) {
////
////            if($this->check_permission('invoice-retrieve')){
////                $keyword = $request->get('keyword');
////                $result = $this->invoice->model()
////                    ->with(['customer' => function($query) use ($keyword){
////                        $query->where('owner_name', 'like', '%'.$keyword.'%')
////                            ->orWhere('company_name', 'like', '%'.$keyword.'%');
////                    }])
////                    ->with(['business' => function($query) use ($keyword){
////                        $query->where('business_name', 'like', '%'.$keyword.'%');
////                    }])
////                    ->with('business')->with('customer')
////                    ->get();
////
////                return $this->response($result);
////            }
////
////
////            return $this->permission_denied();
////        }
////        return $this->unauthorized();
////    }
//
//    public function delete(Request $request, $id){
//        if ($this->check_api_key($request)) {
//            $this->schedule->delete($id);
//            return $this->success();
//        }
//        return $this->unauthorized();
//    }
//
//    public function getAll(Request $request){
//        if ($this->check_api_key($request)) {
//            $schedules = $this->schedule->getAll();
//            return $this->response($schedules);
//        }
//        return response()->json($this->unauthorized);
//    }
//}
