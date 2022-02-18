<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Client extends Model
{
    /**
     * @var array
     */
    protected $fillable = ['user_id', 'name', 'phone', 'email', 'country', 'state', 'city', 'address'];

    /**
     * @return \Illuminate\Database\Eloquent\Relations\HasMany
     * @Author Khuram Qadeer.
     */
    public function invoices()
    {
        return $this->hasMany(ClientInvoice::class);
    }

    /**
     * @return \Illuminate\Database\Eloquent\Relations\HasMany
     * @Author Khuram Qadeer.
     */
    public function payments()
    {
        return $this->hasMany(ClientPayment::class);
    }
}
