<?php

namespace App\Models\Users;

use App\Interfaces\Models\HasRoleInterface;
use App\Models\User;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class Customer extends User implements HasRoleInterface
{
    use HasFactory;

    public function getRole(): string
    {
        return 'customer';
    }

    public function user(): BelongsTo
    {
        return $this->belongsTo(User::class);
    }
}
