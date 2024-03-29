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
            'search' => 'revenue-retrieve',
            'search_by_date' => 'revenue-retrieve',
        ]);
    }

    public function index()
    {
        $invoice = $this->invoice->model()->whereHas('receipt')->with(['member', 'business', 'receipt'])->paginate(20);
        return $this->response($invoice);
    }

    public function search(Request $request)
    {
        $keyword = $request->get('keyword');
        $result = $this->invoice->model()
            ->whereHas('receipt')
            ->whereHas('member', function ($query) use ($keyword) {
                $query->where('company_name', 'like', '%' . $keyword . '%');
            })
            ->with(['business', 'member', 'receipt'])
            ->get();

        return $this->response($result);
    }

    public function search_by_date(Request $request)
    {
        $from = $request->get('from');
        $to = $request->get('to');
        $result = $this->invoice->model()
            ->whereHas('receipt', function ($query) use ($from, $to) {
                $query->whereBetween('created_at', [$from, $to]);
            })
            ->with(['business', 'member', 'receipt'])
            ->get();

        return $this->response($result);
    }


}
