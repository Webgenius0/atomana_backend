<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class SalesTrackView extends Model
{
    // Define the name of the view table
    protected $table = 'sales_tracks_view';

    // Since views are read-only, you typically don't want to allow updates
    public $incrementing = false;  // Prevents the model from trying to increment an ID field
    public $timestamps = false;    // Views typically don't have timestamps


    /**
     * Get the attributes that should be cast.
     *
     * @return array<string, string>
     */
    protected function casts(): array
    {
        return [
            'id'                  => 'integer',
            'created_at'          => 'datetime',
            'price'               => 'float',
            'expiration_date'     => 'datetime',
            'user_id'             => 'integer',
            'property_id'         => 'integer',
            'date_under_contract' => 'datetime',
            'closing_date'        => 'datetime',
            'purchase_price'      => 'float',
            'referral_fee_pct'    => 'float',
            'commission_on_sale'  => 'float',
            'business_id'         => 'integer',
            'co_list_percentage'  => 'float',
        ];
    }

    /**
     * acccessor for Price Attribute
     * @param mixed $value
     * @return string
     */
    protected function getPriceAttribute($value): string
    {
        return number_format($value, 2, '.', '');
    }

    /**
     * acccessor for Price Attribute
     * @param mixed $value
     * @return string
     */
    protected function getCommissionOnSaleAttribute($value): string
    {
        return number_format($value, 2, '.', '');
    }

    /**
     * acccessor for purchase_price Attribute
     * @param mixed $value
     * @return string
     */
    protected function getPurchasePriceAttribute($value): string
    {
        return number_format($value, 2, '.', '');
    }

    /**
     * acccessor for referral_fee_pct Attribute
     * @param mixed $value
     * @return string
     */
    protected function getReferralFeePctAttribute($value): string
    {
        return number_format($value, 2, '.', '');
    }

    /**
     * acccessor for CoListPercentage Attribute
     * @param mixed $value
     * @return string
     */
    protected function getCoListPercentageAttribute($value): string
    {
        return  number_format($value, 2, '.', '');
    }
}
