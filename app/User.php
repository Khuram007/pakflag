<?php

namespace App;

use Illuminate\Contracts\Auth\MustVerifyEmail;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use Laravel\Passport\HasApiTokens;

class User extends Authenticatable
{
    use Notifiable, HasApiTokens;

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'name', 'email', 'password',
    ];

    /**
     * The attributes that should be hidden for arrays.
     *
     * @var array
     */
    protected $hidden = [
        'password', 'remember_token',
    ];

    /**
     * The attributes that should be cast to native types.
     *
     * @var array
     */
    protected $casts = [
        'email_verified_at' => 'datetime',
    ];

    public static function getByEmail($email)
    {
        return self::whereEmail($email)->first();
    }

    /**
     * @return \Illuminate\Database\Eloquent\Relations\HasMany
     * @Author Khuram Qadeer.
     */
    public function customers()
    {
        return $this->hasMany(Customer::class);
    }

    /**
     * @return \Illuminate\Database\Eloquent\Relations\HasMany
     * @Author Khuram Qadeer.
     */
    public function expenses()
    {
        return $this->hasMany(Expense::class);
    }

    /**
     * @return \Illuminate\Database\Eloquent\Relations\HasMany
     * @Author Khuram Qadeer.
     */
    public function receivedAmount()
    {
        return $this->hasMany(ReceivedAmount::class);
    }

    /**
     * @return \Illuminate\Database\Eloquent\Relations\HasMany
     * @Author Khuram Qadeer.
     */
    public function employees()
    {
        return $this->hasMany(Employee::class);
    }

    /**
     * @return \Illuminate\Database\Eloquent\Relations\HasMany
     * @Author Khuram Qadeer.
     */
    public function clients()
    {
        return $this->hasMany(Client::class);
    }
}
