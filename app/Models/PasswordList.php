<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class PasswordList extends Model
{

    protected $guarded = ['id'];

    protected $hidden = ['created_at'];
    protected $casts = [
        'created_at' => 'datetime',
        'updated_at' => 'datetime',
    ];
    /**
     * PasswordList belongs to Business Model.
     * @return BelongsTo<Business, PasswordList>
     */
    public function business(): BelongsTo
    {
        return $this->belongsTo(Business::class);
    }
}
