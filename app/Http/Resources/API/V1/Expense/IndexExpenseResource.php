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
        foreach ($datas['data'] as $data) {
            $tempArray = [
                'id'                      => $data['id'] ?? null,
                'expense_category_id'     => $data['expense_category_id'] ?? null,
                'expense_category'        => isset($data['category']) && isset($data['category']['name']) ? $data['category']['name'] : null,
                'expense_sub_category_id' => $data['expense_sub_category_id'] ?? null,
                'sub_category'            => isset($data['sub_category']) && isset($data['sub_category']['name']) ? $data['sub_category']['name'] : null,
                'amount'                  => $data['amount'] ?? null,
                'payment_method_id'       => $data['payment_method_id'] ?? null,
                'payment_method'          => isset($data['payment_methord']) && isset($data['payment_methord']['name']) ? $data['payment_methord']['name'] : null,
                'payee'                   => $data['payee'] ?? null,
                'recept_name'             => $data['recept_name'] ?? null,
                'recept_url'              => $data['recept_url'] ?? null,
                'owner'                   => isset($data['user']) && isset($data['user']['handle']) ? $data['user']['handle'] : null,
                'reimbursable'            => $data['reimbursable'] ?? null,
                'listing'                 => $data['listing'] ?? null,
                'note'                    => $data['note'] ?? null,
                'description'             => $data['description'] ?? null,
                'date'                    => $data['created_at'] ?? null,
            ];


            $modifyedData[] = $tempArray;
        }

        $datas['data'] = $modifyedData;

        return $datas;
    }
}
