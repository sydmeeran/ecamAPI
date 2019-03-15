<?php

namespace App\Http\Controllers\Api;

use App\Mail\QuotationEmail;
use App\Repositories\DataRepo;
use Arga\Utils\ActionMiddlewareTrait;
use Illuminate\Http\Request;
use Mail;

class QuotationController extends BaseController
{
    use ActionMiddlewareTrait;

    protected $quotation;

    public function __construct()
    {
        $this->actionMiddleware([
            'pagination' => 'quotation-retrieve',
            'get' => 'quotation-retrieve',
            'store' => 'quotation-create',
            'update' => 'quotation-update',
            'search' => 'quotation-retrieve',
            'send_mail' => 'quotation-retrieve',
            'cancel' => 'quotation-delete',
        ]);

        $this->quotation = DataRepo::quotation();
    }

    public function pagination()
    {
        $quotation = $this->quotation->model()
            ->with('member')->with('business')->with('active_invoice')->paginate(20);
        return $this->response($quotation);
    }

    public function get($id)
    {
        $quotation = $this->quotation->with(['member', 'business', 'accounting_service', 'auditing', 'consulting', 'taxation', 'active_invoice'], $id)->toArray();
        if (empty($quotation)) {
            return $this->empty_data();
        }
        $quotation = $quotation[0];
        return $this->response($quotation);
    }

    public function store(Request $request)
    {
        return $this->quotation->store($request);
    }

    public function update(Request $request, $id)
    {
        return $this->quotation->update($request, $id);
    }

    public function search(Request $request)
    {
        $keyword = $request->get('keyword');
        $result = $this->quotation->model()
            ->whereHas('member', function ($query) use ($keyword) {
                $query->where('owner_name', 'like', '%' . $keyword . '%')
                    ->orWhere('company_name', 'like', '%' . $keyword . '%');
            })
            ->orWhereHas('business', function ($query) use ($keyword) {
                $query->where('business_name', 'like', '%' . $keyword . '%');
            })
            ->orWhere('quotation_id', 'like', '%' . $keyword . '%')
            ->with(['business', 'member'])
            ->get();

        return $this->response($result);
    }

    public function send_mail($id)
    {
        $quotation = $this->quotation->with(['member', 'business', 'accounting_service', 'auditing', 'consulting', 'taxation'], $id)->toArray();
        Mail::to($quotation[0]['member']['email'])->send(new QuotationEmail($quotation));
        return 'success';
    }

    public function cancel($id)
    {
        $this->quotation->model()->where('id', $id)->update(['is_active' => 0]);
        return $this->success();
    }

    public function delete($id)
    {
        $this->quotation->model()->where('id', $id)->delete();
        return $this->success();
    }
}
