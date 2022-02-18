<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Payment extends Model
{
    /**
     * @var array
     */
    protected $fillable = ['customer_id', 'type', 'payment_type','amount', 'date'];

    /**
     * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
     * @Author Khuram Qadeer.
     */
    public function customer()
    {
        return $this->belongsTo(Customer::class);
    }
}
