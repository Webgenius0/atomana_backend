<?php

namespace App\Http\Requests\API\V1\Property;

use App\Rules\API\V1\Property\CoAgentNotAuthenticated;
use App\Rules\API\V1\Property\CoAgentPercentage;
use App\Traits\V1\ApiResponse;
use Illuminate\Contracts\Validation\Validator;
use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\ValidationException;

class CreatePropertyRequest extends FormRequest
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
            'email'              => 'required|email' ,
            'address'            => 'required|string' ,
            'price'              => ['required', 'numeric', 'regex:/^\d+(\.\d{1,2})?$/'] ,
            'expiration_date'    => 'required|date|after:today' ,
            'is_development'     => 'required|boolean' ,
            'add_to_website'     => 'nullable|boolean' ,
            'is_co_listing'      => 'required|boolean' ,
            'co_agent'           => [new CoAgentNotAuthenticated, 'nullable'],
            'co_list_percentage' => [new CoAgentPercentage, 'nullable'],
            'source'             => 'required|string',
        ];
    }

    public function messages(): array
    {
        return [
            'email.required'                 => 'Please provide an email address.',
            'email.email'                    => 'The email address must be in a valid email format.',

            'address.required'               => 'The address field cannot be empty.',

            'price.required'                 => 'The price is required to complete this action.',
            'price.numeric'                  => 'The price must be a numeric value.',
            'price.regex'                    => 'The price must be a valid number with up to two decimal places.',

            'expiration_date.required'       => 'The expiration date is required.',
            'expiration_date.date'           => 'The expiration date must be in a valid date format.',
            'expiration_date.after'          => 'The expiration date must be a future date.',

            'development.required'           => 'Please specify if it is a development property.',
            'development.boolean'            => 'The development field must be true or false.',

            'co_list_percentage.numeric'     => 'The co-listing percentage must be a numeric value.',
            'co_list_percentage.regex'       => 'The co-listing percentage must be a valid number with up to two decimal places.',
            'co_list_percentage.min'         => 'The co-listing percentage must be at least 0.',
            'co_list_percentage.max'         => 'The co-listing percentage must not exceed 100.',

            'source.required'                => 'The source of the listing is required.',
            'source.string'                  => 'The source must be a valid string.',
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
            'email',
            'address',
            'price',
            'expiration_date',
            'development',
            'co_agent',
            'co_list_percentage',
            'source',
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
