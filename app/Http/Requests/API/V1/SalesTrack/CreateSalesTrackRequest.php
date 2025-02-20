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
            'user_id' => 'required|exists:users,id',
            'property_id' => 'required|exists:properties,id',
            'price' => ['required', 'numeric', 'regex:/^\d+(\.\d{1,2})?$/'],
            'status' => 'required|boolean',
            'expiration_date' => 'required|date|after:today',
            'note' => 'required|string',
        ];
    }


    public function messages(): array
    {
        return [
            'user_id.required' => 'The user field is mandatory.',
            'user_id.exists' => 'The selected user does not exist in our records.',
            'property_id.required' => 'The property field is mandatory.',
            'property_id.exists' => 'The selected property is not available.',
            'price.required' => 'Please provide a price.',
            'price.numeric' => 'The price must be a valid number.',
            'price.regex' => 'The price format must be a valid number with up to two decimal places.',
            'status.required' => 'The status field is mandatory.',
            'status.boolean' => 'The status must be either true or false.',
            'expiration_date.required' => 'The expiration date is required.',
            'expiration_date.date' => 'The expiration date must be a valid date format.',
            'expiration_date.after' => 'The expiration date must be a feture date.',
            'note.required' => 'A note is required.',
            'note.string' => 'The note must be a valid string.',
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
            'user_id',
            'property_id',
            'price',
            'status',
            'expiration_date',
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
