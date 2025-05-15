<?php

namespace App\Http\Requests\Api\V1\Property;

use App\Rules\API\V1\Property\CoAgentNotAuthenticated;
use App\Rules\API\V1\Property\CoAgentPercentage;
use Illuminate\Contracts\Validation\Validator;
use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\ValidationException;

class UpdateRequest extends FormRequest
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
            'address'            => 'required|string',
            'price'              => ['required', 'numeric', 'regex:/^\d+(\.\d{1,2})?$/'],
            'expiration_date'    => 'required|string',
            'is_development'     => 'required|date|after:today',
            'add_to_website'     => 'nullable|boolean',
            'commission_rate'    => ['required', 'numeric', 'regex:/^\d+(\.\d{1,2})?$/', 'max:100', 'min:0.01'],
            'agent'              => 'required|boolean',
            'co_agent'           => [new CoAgentNotAuthenticated],
            'co_list_percentage' => [new CoAgentPercentage],
            'property_source_id' => 'required|exists:property_sources,id',
            'beds'               => 'nullable|integer',
            'full_baths'         => 'nullable|integer',
            'half_baths'         => 'nullable|integer',
            'size'               => ['nullable', 'numeric', 'regex:/^\d+(\.\d{1,2})?$/', 'min:0.01'],
            'link'               => 'nullable|url',
            'note'               => 'nullable|string',
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
        $message = 'validation error';
        $fields = [
            'address',
            'price',
            'expiration_date',
            'is_development',
            'add_to_website',
            'commission_rate',
            'agent',
            'co_agent',
            'co_list_percentage',
            'property_source_id',
            'beds',
            'full_baths',
            'half_baths',
            'size',
            'link',
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
