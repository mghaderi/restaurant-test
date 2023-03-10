<?php

namespace App\Domains\Vendor\Models;

use App\Domains\Order\Models\Order;
use Database\Factories\Vendor\VendorFactory;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;

class Vendor extends Model
{
    use HasFactory;

    protected $fillable = [
        'name',
        'address',
        'postal_code',
        'number',
    ];

    public function orders(): HasMany
    {
        return $this->hasMany(
            Order::class,
            'order_id',
            'id'
        );
    }

    protected static function newFactory()
    {
        return VendorFactory::new();
    }
}
