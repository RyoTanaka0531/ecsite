<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class CartItem extends Model
{
    //編集可能なカラムをあらかじめ指定しておく
    protected $fillable = ['user_id', 'item_id', 'quantity'];
}
