<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Order extends Model
{
    //

   protected $fillable = [
        'customer_id',
        'quantity',
        'price',
        'total',
        'status',
        'note',
    ];
    
    protected $casts = [
        'quantity' => 'integer',
        'price' => 'decimal:2',
        'total' => 'decimal:2',
    ];
    
    // Relationship with Customer
    public function customer()
    {
        return $this->belongsTo(Customer::class);
    }
    
    // Accessor for formatted order ID
    public function getFormattedIdAttribute()
    {
        return '#ORD-' . str_pad($this->id, 5, '0', STR_PAD_LEFT);
    }

}
