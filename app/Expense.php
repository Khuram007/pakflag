<?php

namespace App;

use Carbon\Carbon;
use Illuminate\Database\Eloquent\Model;

class Expense extends Model
{
    /**
     * @var array
     */
    protected $fillable = ['user_id', 'title', 'description', 'amount', 'expense_at'];

    /**
     * @return mixed
     */
    public function ScopeCurrentMonthExpense()
    {
        return $this->whereMonth('created_at', Carbon::now()->month);
    }
}
