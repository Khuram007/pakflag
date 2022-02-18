<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class AdvanceSalary extends Model
{
    /**
     * @var array
     */
    protected $fillable = ['employee_id', 'amount'];
}
