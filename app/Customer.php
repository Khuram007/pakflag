<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Customer extends Model
{
    /**
     * @var array
     */
    protected $fillable = ['user_id', 'name', 'phone', 'email', 'country', 'state', 'city', 'address'];

    /**
     * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
     * @Author Khuram Qadeer.
     */
    public function user()
    {
        return $this->belongsTo(User::class);
    }

    /**
     * @return \Illuminate\Database\Eloquent\Relations\HasMany
     * @Author Khuram Qadeer.
     */
    public function payments()
    {
        return $this->hasMany(Payment::class);
    }

    /**
     * @return \Illuminate\Database\Eloquent\Relations\HasMany
     * @Author Khuram Qadeer.
     */
    public function invoices()
    {
        return $this->hasMany(Invoice::class);
    }

}
