<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class ClientInvoice extends Model
{
    /**
     * @var array
     */
    protected $fillable = ['client_id', 'type', 'date', 'rate', 'weight', 'delivered_form', 'amount'];

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
    public function items()
    {
        return $this->hasMany(ClientInvoiceItem::class);
    }
}
