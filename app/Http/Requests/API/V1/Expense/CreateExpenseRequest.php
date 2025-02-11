<?php

namespace App\Http\Requests\API\V1\Expense;

use Illuminate\Foundation\Http\FormRequest;

class CreateExpenseRequest extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     */
    public function authorize(): bool
    {
        return true;
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array<string, \Illuminate\Contracts\Validation\ValidationRule|array<mixed>|string>
     */
    public function rules(): array
    {
        return [
            'expense_for_id' => 'required|exists:expense_fors,id',
            'expense_type_id' => 'required|exists:expense_types,id',
            'expense_category_id' => 'required|exists:expense_categories,id',
            'expense_sub_category_id' => 'required|exists:expense_sub_categories,id',
            'description' => 'required|string',
            'amount' => 'required|numeric',
            'payment_method_id' => 'required|exists:payment_methods,id',
            'vendor_id' => 'required|exists:vendors,id',
            'recept_name' => 'required|string',
            // 'recept_name_url' => 'nullable|string',
            'owner' => 'required|string',
            'reimbursable' => 'required|boolean',
            'listing' => 'required|string',
            'note' => 'required|string',
        ];
    }
}
