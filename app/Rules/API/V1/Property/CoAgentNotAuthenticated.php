<?php

namespace App\Rules\API\V1\Property;

use App\Models\User;
use Closure;
use Illuminate\Contracts\Validation\ValidationRule;
use Illuminate\Support\Facades\Auth;

class CoAgentNotAuthenticated implements ValidationRule
{
    /**
     * Run the validation rule.
     *
     * @param  \Closure(string, ?string=): \Illuminate\Translation\PotentiallyTranslatedString  $fail
     */
    public function validate(string $attribute, mixed $value, Closure $fail): void
    {
        if ($value && $value == Auth::id()) {
            $fail('The co-agent cannot be the same as the authenticated user.');
        }
        
        // Check if the co_agent exists in the users table
        if ($value && !User::find($value)) {
            $fail('The selected co-agent must be a valid user.');
        }
    }
}
