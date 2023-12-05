<?php

namespace Atlas\SuperFunds\Models;

use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Model;

class SuperFund extends Model
{
    protected $casts = [
        'restricts_contributions' => 'boolean',
        'valid' => 'bool',
        'valid_from' => 'date:Y-m-d',
        'valid_to' => 'date:Y-m-d',
    ];

    /**
     * Scope a query to only include valid super funds.
     */
    public function scopeValid(Builder $query): void
    {
        $query->where('valid', '=', true);
    }
}
