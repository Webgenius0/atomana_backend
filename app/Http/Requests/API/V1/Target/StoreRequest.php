<?php

namespace App\Http\Requests\API\V1\Target;

use App\Traits\V1\ApiResponse;
use Illuminate\Contracts\Validation\Validator;
use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\ValidationException;

class StoreRequest extends FormRequest
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
            'month'  => 'date',
            'amount' => ['required', 'numeric', 'regex:/^\d+(\.\d{1,2})?$/'],
            'for'    => 'required|in:current_sales,units_sold,expenses,gross_profit',
        ];
    }


    public function messages(): array
    {
        return [
            'month.date'      => 'The month must be a valid date format.',
            'amount.required' => 'The amount is required.',
            'amount.numeric'  => 'The amount must be a number.',
            'amount.regex'    => 'The amount must be a valid number with up to two decimal places.',
            'for.required'    => 'The for field is required.',
            'for.in'          => 'The for field must be one of the following values: current_sales, units_sold, expenses, or gross_profit.',
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
            'month',
            'amount',
            'for',
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
