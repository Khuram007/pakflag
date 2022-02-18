<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class ClientInvoiceItem extends Model
{
    /**
     * @var array
     */
    protected $fillable = [
        'client_id',
        'client_invoice_id',
        'type',
        'date',
        'rate',
        'weight',
        'description',
        'rupees',
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
    public function client()
    {
        return $this->belongsTo(Client::class);
    }

    /**
     * @return \Illuminate\Database\Eloquent\Relations\HasMany
     * @Author Khuram Qadeer.
     */
    public function invoice()
    {
        return $this->hasMany(ClientInvoice::class, 'id', 'client_invoice_id');
    }
}
