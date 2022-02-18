<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Invoice extends Model
{
    /**
     * @var array
     */
    protected $fillable = ['customer_id', 'type', 'date', 'rate', 'weight', 'delivered_form', 'amount'];

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
    public function items()
    {
        return $this->hasMany(InvoiceItem::class);
    }
}
