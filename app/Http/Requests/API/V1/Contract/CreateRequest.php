<?php

namespace App\Http\Requests\API\V1\Contract;

use App\Rules\API\V1\Property\CoAgentNotAuthenticated;
use App\Traits\V1\ApiResponse;
use Illuminate\Foundation\Http\FormRequest;

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
            'agent'                => 'required|integer|exists:agents,id',
            'address'              => 'nullable|string|max:255',
            'closing_data'         => 'nullable|date',
            'is_co_listing'        => 'required|boolean',
            'co_agent'             => [new CoAgentNotAuthenticated],
            'represent'            => 'required|in:buyer,seller,both',
            'date_listed'          => 'required_if:represent,seller,both|date',
            'price'                => 'nullable|numeric|min:0',
            'contract_data'        => 'nullable|date',
            'commision_percentage' => 'nullable|numeric|min:0|max:100',
            'property_source_id'   => 'nullable|exists:property_sources,id',
            'name'                 => 'nullable|string|max:255',
            'company'              => 'nullable|string|max:255',
            'email'                => 'nullable|email|max:255',
            'phone'                => 'nullable|string|max:20',
        ];
    }
}
