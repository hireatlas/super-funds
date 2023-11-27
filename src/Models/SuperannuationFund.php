<?php

namespace Atlas\LaravelAustralianSuperannuationFunds\Models;

use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Model;

class SuperannuationFund extends Model
{
    protected $casts = [
        'restricts_contributions' => 'boolean',
        'valid' => 'bool',
        'valid_from' => 'date:Y-m-d',
        'valid_to' => 'date:Y-m-d',
    ];

    /**
     * Scope a query to only include valid superannuation funds.
     */
    public function scopeValid(Builder $query): void
    {
        $query->where('valid', '=', true);
    }
}
