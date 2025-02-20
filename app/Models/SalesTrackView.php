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

    // Define the columns you want to be fillable or guarded
    protected $fillable = [
        'id',
        'first_name',
        'last_name',
        'address',
        'user_id',
        'property_id',
        'price',
        'status',
        'expiration_date',
        'note',
    ];

    /**
     * acccessor for Price Attribute
     * @param mixed $value
     * @return string
     */
    protected function getPriceAttribute($value):string
    {
        return number_format($value, 2, '.', '');
    }
}
