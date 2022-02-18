<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class ClientPayment extends Model
{
    /**
     * @var array
     */
    protected $fillable = ['client_id', 'type', 'payment_type','amount', 'date'];

    /**
     * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
     * @Author Khuram Qadeer.
     */
    public function client()
    {
        return $this->belongsTo(Client::class);
    }
}
