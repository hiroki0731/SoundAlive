<?php

namespace App\Http\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Concert extends Model
{
    //論理削除有効化
    use SoftDeletes;

    protected $guarded = ['id'];

    protected $dates = ['deleted_at'];
}
