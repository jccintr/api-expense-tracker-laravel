<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Transaction extends Model
{
    protected $table ='transactions';
    protected $fillable = ['description','amount','category_id','account_id','user_id'];

    protected $hidden = [
        'updated_at',
    ];
}
