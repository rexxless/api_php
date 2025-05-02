<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class Order extends Model
{
    use HasFactory;

    public function user(): BelongsTo
    {
        return $this->belongsTo(User::class);
    }

    protected $table = 'orders';

    protected $fillable = [
        'user_id',
        'products',
        'order_price'
    ];

    protected $casts = [
        'products' => 'array'
    ];
    protected $hidden = ['user_id'];
    public $timestamps = false;
}
