<?php

namespace App\Http\Controllers\Api;

use App\Repositories\DataRepo;
use Arga\Utils\ActionMiddlewareTrait;
use Illuminate\Http\Request;

class RevenueController extends BaseController
{
    use ActionMiddlewareTrait;

    protected $revenue;

    public function __construct()
    {
        $this->invoice = DataRepo::invoice();

        $this->actionMiddleware([
            'index' => 'revenue-retrieve',
        ]);
    }

    public function index(Request $request){
        if ($this->check_api_key($request)) {
            $invoice = $this->invoice->model()->whereHas('receipt')->with(['customer', 'business', 'receipt'])->paginate(20);
            return $this->response($invoice);
        }
        return $this->unauthorized();
    }

    public function search(Request $request){
        if ($this->check_api_key($request)) {
                $keyword = $request->get('keyword');
                $result = $this->invoice->model()
                    ->whereHas('receipt')
                    ->whereHas('customer', function($query) use ($keyword){
                        $query->where('company_name', 'like', '%'.$keyword.'%');
                    })
                    ->with(['business', 'customer', 'receipt'])
                    ->get();

                return $this->response($result);
        }
        return $this->unauthorized();
    }

    public function search_by_date(Request $request){
        if ($this->check_api_key($request)) {
            $from = $request->get('from');
            $to = $request->get('to');
            $result = $this->invoice->model()
                ->whereHas('receipt', function($query) use ($from, $to){
                    $query->whereBetween('created_at', [$from, $to]);
                })
                ->with(['business', 'customer', 'receipt'])
                ->get();

            return $this->response($result);
        }
        return $this->unauthorized();
    }


}
