<?php

namespace App\Http\Requests\API\V1\Expense;

use App\Traits\V1\ApiResponse;
use Illuminate\Contracts\Validation\Validator;
use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\ValidationException;

class CreateExpenseRequest extends FormRequest
{
    use ApiResponse;
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
            'expense_type_id' => 'nullable|exists:expense_types,id',
            'expense_category_id' => 'nullable|exists:expense_categories,id',
            'expense_sub_category_id' => 'nullable|exists:expense_sub_categories,id',
            'description' => 'nullable|string',
            'amount' => ['nullable', 'numeric', 'regex:/^\d+(\.\d{1,2})?$/'],
            'payment_method_id' => 'nullable|exists:payment_methods,id',
            'vendor_id' => 'nullable|exists:vendors,id',
            'recept' => 'nullable|file|mimes:jpg,jpeg,png,webp,pdf',
            'owner' => 'nullable|string',
            'reimbursable' => 'nullable|boolean',
            'listing' => 'nullable|string',
            'note' => 'nullable|string',
        ];
    }


    /**
     * custom message
     */
    public function messages(): array
    {
        return [
            // 'expense_type_id.required' => 'The expense type is required.',
            'expense_type_id.exists' => 'The selected expense type is invalid.',

            // 'expense_category_id.required' => 'The expense category is required.',
            'expense_category_id.exists' => 'The selected expense category is invalid.',

            // 'expense_sub_category_id.required' => 'The expense sub-category is required.',
            'expense_sub_category_id.exists' => 'The selected expense sub-category is invalid.',

            // 'description.required' => 'The description is required.',
            'description.string' => 'The description must be a string.',

            // 'amount.required' => 'The amount is required.',
            'amount.numeric' => 'The amount must be a numeric value.',
            'amount.regex' => 'The amount must be a valid number with up to two decimal places.',

            // 'payment_method_id.required' => 'The payment method is required.',
            'payment_method_id.exists' => 'The selected payment method is invalid.',

            // 'vendor_id.required' => 'The vendor is required.',
            'vendor_id.exists' => 'The selected vendor is invalid.',

            // 'recept.required' => 'The receipt is required.',
            'recept.file' => 'The receipt must be a valid file.',
            'recept.mimes' => 'The receipt must be a JPG, JPEG, PNG, WEBP, or PDF file.',

            // 'owner.required' => 'The owner is required.',
            'owner.string' => 'The owner must be a string.',

            // 'reimbursable.required' => 'Reimbursement status is required.',
            'reimbursable.boolean' => 'Reimbursement status must be a boolean.',

            // 'listing.required' => 'The listing is required.',
            'listing.string' => 'The listing must be a string.',

            // 'note.required' => 'The note is required.',
            'note.string' => 'The note must be a string.',
        ];
    }




    /**
     * Handles failed validation by formatting the validation errors and throwing a ValidationException.
     *
     * This method is called when validation fails in a form request. It uses the `error` method
     * from the `ApiResponse` trait to generate a standardized Errorsresponse with the validation
     * Errorsmessages and a 422 HTTP status code. It then throws a `ValidationException` with the
     * formatted response.
     *
     * @param Validator $validator The validator instance containing the validation errors.
     *
     * @return void Throws a ValidationException with a formatted Errorsresponse.
     *
     * @throws ValidationException The exception is thrown to halt further processing and return validation errors.
     */
    protected function failedValidation(Validator $validator): never
    {
        $errors = $validator->errors()->getMessages();
        $message = null;
        $fields = [
            'expense_type_id',
            'expense_category_id',
            'expense_sub_category_id',
            'description',
            'amount',
            'payment_method_id',
            'vendor_id',
            'recept',
            // 'recept_name_url',
            'owner',
            'reimbursable',
            'listing',
            'note',
        ];

        foreach ($fields as $field) {
            if (isset($errors[$field])) {
                $message = $errors[$field][0];
                break;
            }
        }

        $response = $this->error(
            422,
            $message,
            $validator->errors(),
        );
        throw new ValidationException($validator, $response);
    }
}
