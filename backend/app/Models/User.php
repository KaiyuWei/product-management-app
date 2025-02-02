<?php

namespace App\Models;

use App\Interfaces\Models\HasRoleInterface;
use App\Models\Users\Customer;
use App\Models\Users\Supplier;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Relations\HasOne;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use Illuminate\Support\Facades\Log;
use Laravel\Sanctum\HasApiTokens;

class User extends Authenticatable
{
    use HasFactory, Notifiable, HasApiTokens;

    /**
     * The attributes that are mass assignable.
     *
     * @var array<int, string>
     */
    protected $fillable = [
        'name',
        'email',
        'password',
        'role',
    ];

    /**
     * The attributes that should be hidden for serialization.
     *
     * @var array<int, string>
     */
    protected $hidden = [
        'password',
        'remember_token',
    ];

    public const ROLE_OPTIONS = ['supplier', 'customer'];

    /**
     * Get the attributes that should be cast.
     *
     * @return array<string, string>
     */
    protected function casts(): array
    {
        return [
            'email_verified_at' => 'datetime',
            'password' => 'hashed',
        ];
    }

    public function roleInstance()
    {
        switch ($this->role) {
            case 'supplier':
                return $this->hasOne(Supplier::class);
            case 'customer':
                return $this->hasOne(Customer::class);
            default:
                throw new \Exception('Unrecognized role', 400);
        }
    }

    public function customer(): HasOne
    {
        return $this->hasOne(Customer::class);
    }

    public function supplier(): HasOne
    {
        return $this->hasOne(Supplier::class);
    }
}
