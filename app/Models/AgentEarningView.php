<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class AgentEarningView extends Model
{
    /**
     * Get the attributes that should be cast.
     *
     * @return array<string, string>
     */
    protected function casts(): array
    {
        return [
            'user_id' => 'integer',
            'business_id' => 'integer',
            'sales_closed' => 'integer',
            'dollars_on_closed_deals_ytd' => 'float',
            'current_year_start' => 'date',
            'gross_commission_income_ytd' => 'float',
            'brokerage_cur_ytd' => 'float',
            'net_commission_ytd' => 'float',
        ];
    }

    /**
     * belongs to user
     * @return BelongsTo<User, AgentEarningView>
     */
    public function user():BelongsTo
    {
        return $this->belongsTo(User::class);
    }

    /**
     * belongs to business
     * @return BelongsTo<Business, AgentEarningView>
     */
    public function business():BelongsTo
    {
        return $this->belongsTo(Business::class);
    }
}
