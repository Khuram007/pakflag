<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class InvoiceItem extends Model
{
    /**
     * @var array
     */
    protected $fillable = [
        'customer_id',
        'invoice_id',
        'type',
        'date',
        'rate',
        'weight',
        'delivered_form',
        'amount',
        'qty',
        'credit',
        'debit',
        'balance'
    ];

    /**
     * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
     * @Author Khuram Qadeer.
     */
    public function customer()
    {
        return $this->belongsTo(Customer::class);
    }

    /**
     * @return \Illuminate\Database\Eloquent\Relations\HasMany
     * @Author Khuram Qadeer.
     */
    public function invoice()
    {
        return $this->hasMany(Invoice::class, 'id', 'invoice_id');
    }
}
