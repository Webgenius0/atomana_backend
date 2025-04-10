<?php

namespace App\Http\Requests\API\V1\Property\AccessInstruction;

use App\Traits\V1\ApiResponse;
use Illuminate\Contracts\Validation\Validator;
use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\ValidationException;

class CreateRequest extends FormRequest
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
            "property_id"=> "required|exists:properties,id",
            "property_types_id"=> "required|exists:property_types,id",
            "size"=> "nullable|string",
            "access_key"=> "nullable|string",
            "lock_box_location"=> "nullable|string",
            "pickup_instructions"=> "nullable|string",
            "gate_code"=> "nullable|string",
            "gete_access_location"=> "nullable|string",
            "visitor_parking"=> "nullable|string",
            "note"=> "nullable|string",
        ];
    }

    /**
     * failedValidation
     * @param \Illuminate\Contracts\Validation\Validator $validator
     * @throws \Illuminate\Validation\ValidationException
     * @return never
     */
    protected function failedValidation(Validator $validator): never
    {
        $errors = $validator->errors()->getMessages();
        $message = null;
        $fields = [
            'property_id',
            'property_types_id',
            'size',
            'access_key',
            'lock_box_location',
            'pickup_instructions',
            'source',
            'gete_access_location',
            'visitor_parking',
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
