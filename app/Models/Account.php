<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Account extends Model
{
    protected $table ='accounts';
    protected $fillable = ['name','user_id'];
    
    protected $hidden = [
        'created_at',
        'updated_at',
    ];
}
