<?php

namespace App;

use Carbon\Carbon;
use Illuminate\Database\Eloquent\Model;

class ReceivedAmount extends Model
{
    /**
     * @var array
     */
    protected $fillable = ['user_id','date', 'description', 'amount'];

    /**
     * @return mixed
     */
    public function ScopeCurrentMonth()
    {
        return $this->whereMonth('created_at', Carbon::now()->month);
    }
}
