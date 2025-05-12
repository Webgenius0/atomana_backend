<?php

namespace App\Http\Requests\API\V1\Contract;

use App\Rules\API\V1\Property\CoAgentNotAuthenticated;
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
            'business_id'          => 'required|exists:businesses,id',
            'agent'                => 'required|integer|exists:users,id',
            'address'              => 'nullable|string|max:255',
            'closing_data'         => 'nullable|date',
            'is_co_listing'        => 'required|boolean',
            'co_agent'             => [new CoAgentNotAuthenticated],
            'represent'            => 'required|in:buyer,seller,both',
            'date_listed'          => 'required_if:represent,seller,both|date',
            'price'                => 'required|numeric|min:0',
            'contract_data'        => 'nullable|date',
            'commision_percentage' => 'nullable|numeric|min:0|max:100',
            'property_source_id'   => 'required|exists:property_sources,id',
            'name'                 => 'required|string|max:255',
            'company'              => 'required|string|max:255',
            'email'                => 'nullable|email|max:255',
            'phone'                => 'nullable|string|max:20',
            'comment'              => 'nullable|string',
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
            'business_id',
            'agent',
            'address',
            'closing_data',
            'is_co_listing',
            'co_agent',
            'represent',
            'date_listed',
            'price',
            'contract_data',
            'commision_percentage',
            'property_source_id',
            'name',
            'company',
            'email',
            'phone',
            'comment',
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
