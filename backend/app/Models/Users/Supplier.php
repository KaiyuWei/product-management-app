<?php

namespace App\Models\Users;

use App\Interfaces\Models\HasRoleInterface;
use App\Models\Product;
use App\Models\User;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;

class Supplier extends User implements HasRoleInterface
{
    use HasFactory;

    public function getRole(): string
    {
        return 'supplier';
    }

    public function user(): BelongsTo
    {
        return $this->belongsTo(User::class);
    }

    public function products(): BelongsToMany
    {
        return $this->belongsToMany(Product::class, 'product_supplier')
            ->withPivot('status');
    }
}
