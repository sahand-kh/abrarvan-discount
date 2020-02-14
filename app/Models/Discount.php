<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Discount extends Model
{
    public $timestamps = false;
    protected $fillable = [
      'count', 'value', 'code'
    ];


    public function codeExists($code)
    {
        return $this->where('code', $code)->exists();
    }

    public function reduceCount()
    {
        $this->count--;
        $this->save();
    }
}
