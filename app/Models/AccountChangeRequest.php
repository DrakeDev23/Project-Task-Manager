<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class AccountChangeRequest extends Model
{
    protected $fillable = ['user_id', 'type', 'payload', 'token_hash', 'expires_at', 'used_at'];

    protected $casts = [
        'payload' => 'encrypted:array',
        'expires_at' => 'datetime',
        'used_at' => 'datetime',
    ];

    public function user(): BelongsTo
    {
        return $this->belongsTo(User::class);
    }
}
