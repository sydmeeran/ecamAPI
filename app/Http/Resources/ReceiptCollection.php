<?php

namespace App\Http\Resources;

use App\Receipt;
// use Illuminate\Http\Resources\Json\ResourceCollection;
use Illuminate\Http\Resources\Json\JsonResource;

class ReceiptCollection extends JsonResource
{
    /**
     * Transform the resource collection into an array.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return array
     */
    public function toArray($request)
    {
        // dd(1);
        return [
          'receipt_id' => $this->receipt_id,
          'company_name' => $this->company_name,
          'email' => $this->email,
          'type' => $this->type,
          'amount' => $this->amount,
          'created_at' => $this->created_at
        ];
    }
}
