<?php

namespace App;

use Carbon\Carbon;
use Illuminate\Database\Eloquent\Model;

class Employee extends Model
{
    /**
     * @var array
     */
    protected $fillable = [
        'user_id',
        'name',
        'phone',
        'email',
        'designation',
        'dob',
        'salary',
        'hourly_rate',
        'city',
        'address',
    ];

    /**
     * @return \Illuminate\Database\Eloquent\Relations\HasMany
     * @Author Khuram Qadeer.
     */
    public function salaries()
    {
        return $this->hasMany(Salary::class);
    }

    /**
     * @return \Illuminate\Database\Eloquent\Relations\HasMany
     * @Author Khuram Qadeer.
     */
    public function advanceSalaries()
    {
        return $this->hasMany(AdvanceSalary::class);
    }

    /**
     * @return \Illuminate\Database\Eloquent\Relations\HasMany
     */
    public function ScopeCurrentMonthSalaries()
    {
        return $this->salaries()->whereMonth('created_at', Carbon::now()->month);
    }

    /**
     * @return \Illuminate\Database\Eloquent\Relations\HasMany
     */
    public function ScopeCurrentMonthAdvanceSalaries()
    {
        return $this->advanceSalaries()->whereMonth('created_at', Carbon::now()->month);
    }
}
