<?php

namespace App\Http\Requests\API\V1\SalesTrack;

use App\Traits\V1\ApiResponse;
use Illuminate\Contracts\Validation\Validator;
use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\ValidationException;

class CreateSalesTrackRequest extends FormRequest
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
            'user_id'             => 'required|exists:users,id',
            'property_id'         => 'required|exists:properties,id',
            'status'              => 'required|in:active,pending,close,expired',

            'date_under_contract' => 'nullable|date',
            'purchase_price'      => ['nullable', 'numeric', 'regex:/^\d+(\.\d{1,2})?$/'],
            'override_split'      => ['nullable', 'numeric', 'regex:/^\d+(\.\d{1,2})?$/', 'min:0.01', 'max:100'],
            'closing_date'        => 'nullable|date',
            'buyer_seller'        => 'nullable|string',
            'referral_fee_pct'    => ['nullable', 'numeric', 'regex:/^\d+(\.\d{1,2})?$/', 'min:0', 'max:100'],
            'commission_on_sale'  => ['nullable', 'numeric', 'min:0', 'max:100', 'regex:/^\d+(\.\d{1,2})?$/'],
            'note'                => 'nullable|string',
        ];
    }


    public function messages(): array
    {
        return [
            'user_id.required' => 'The user field is mandatory.',
            'user_id.exists'   => 'The selected user does not exist in our records.',

            'property_id.required' => 'The property field is mandatory.',
            'property_id.exists'   => 'The selected property is not available.',

            'status.required' => 'The status field is mandatory.',
            'status.in'       => 'The status must be one of the following: active, pending, close, expired.',

            'date_under_contract.required' => 'The date under contract is required.',
            'date_under_contract.date'     => 'The date under contract must be a valid date.',

            'purchase_price.required' => 'The referral fee percentage is required.',
            'purchase_price.numeric'  => 'The referral fee percentage must be a valid number.',
            'purchase_price.regex'    => 'The referral fee percentage format must be a valid number with no more than two decimal places.',

            'override_split.required' => 'The referral fee override split is required.',
            'override_split.numeric'  => 'The referral fee override split must be a valid number.',
            'override_split.regex'    => 'The referral fee override split format must be a valid number with no more than two decimal places.',

            'closing_date.required' => 'The closing date  is required.',
            'closing_date.date'     => 'The closing date  must be a valid date.',

            'note.required' => 'A note is required.',
            'note.string'   => 'The note must be a valid string.',

            'referral_fee_pct.required' => 'The referral fee percentage is required.',
            'referral_fee_pct.numeric'  => 'The referral fee percentage must be a valid number.',
            'referral_fee_pct.regex'    => 'The referral fee percentage format must be a valid number with no more than two decimal places.',

            'commission_on_sale.required' => 'The commission on sale is required.',
            'commission_on_sale.numeric'  => 'The commission on sale must be a valid number.',
            'commission_on_sale.regex'    => 'The commission on sale format must be a valid number with no more than two decimal places.',
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
        $errors  = $validator->errors()->getMessages();
        $message = null;
        $fields  = [
            'user_id',
            'property_id',
            'status',
            'date_under_contract',
            'purchase_price',
            'buyer_seller',
            'referral_fee_pct',
            'commission_on_sale',
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
