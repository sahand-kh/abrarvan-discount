<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class DiscountUserPivot extends Model
{
    public $timestamps = false;
    protected $table = 'discount_user_pivot';
    protected $fillable = ['discount_id', 'wallet_id'];
}
