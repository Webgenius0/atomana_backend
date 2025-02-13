<?php

namespace App\Http\Resources\API\V1\Expense;

use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;
use Illuminate\Support\Facades\Log;

class IndexExpenseResource extends JsonResource
{
    /**
     * Transform the resource into an array.
     *
     * @return array<string, mixed>
     */
    public function toArray(Request $request): array
    {
        $datas = parent::toArray($request);

        $modifyedData = [];
        foreach($datas['data'] as $data){
            $tempArray = [
                'id'                      => $data['id'],
                'expense_type_id'         => $data['expense_type_id'],
                'expense_category_id'     => $data['expense_category_id'],
                'expense_sub_category_id' => $data['expense_sub_category_id'],
                'amount'                  => $data['amount'],
                'payment_method_id'       => $data['payment_method_id'],
                'vendor_id'               => $data['vendor_id'],
                'recept_name'             => $data['recept_name'],
                'recept_url'              => $data['recept_url'],
                'owner'                   => $data['owner'],
                'reimbursable'            => $data['reimbursable'],
                'listing'                 => $data['listing'],
                'note'                    => $data['note'],
                'description'             => $data['description'],
            ];

            $modifyedData[] = $tempArray;
        }

        $datas['data'] = $modifyedData;

        return $datas;
    }
}


