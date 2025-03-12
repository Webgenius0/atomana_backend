<?php

namespace App\Rules\API\V1\Property;

use Closure;
use Illuminate\Contracts\Validation\ValidationRule;
use Illuminate\Support\Facades\Log;

class CoAgentPercentage implements ValidationRule
{
    /**
     * Run the validation rule.
     *
     * @param  \Closure(string, ?string=): \Illuminate\Translation\PotentiallyTranslatedString  $fail
     */
    public function validate(string $attribute, mixed $value, Closure $fail): void
    {
        $coAgent = request()->input('co_agent');

        if ($coAgent && is_null($value)) {
            $fail('The :attribute is required when co_agent is provided.');
            return;
        }

        if (!is_null($value)) {
            // Check if the value is numeric
            if (!is_numeric($value)) {
                $fail('The :attribute must be a valid number.');
                return;
            }

            // Check if the value matches the regex pattern for up to 2 decimal places
            if (!preg_match('/^\d+(\.\d{1,2})?$/', $value)) {
                $fail('The :attribute format is invalid. It should be a number with up to two decimal places.');
                return;
            }

            // Check if the value is greater than or equal to 0
            if ($value < 0) {
                $fail('The :attribute must be at least 0.');
                return;
            }

            // Check if the value is less than or equal to 100
            if ($value > 100) {
                $fail('The :attribute must not be greater than 100.');
                return;
            }
        }
    }
}
