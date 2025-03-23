<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class BusinessInfoView extends Model
{
    /**
     * Get the attributes that should be cast.
     *
     * @return array<string, string>
     */
    protected function casts(): array
    {
        return [
            'business_id' => 'integer',
            'business_total_ytc' => 'float',
        ];
    }

    /**
     * belongs to business
     * @return BelongsTo<Business, BusinessInfoView>
     */
    public function business():BelongsTo
    {
        return $this->belongsTo(Business::class);
    }
}
