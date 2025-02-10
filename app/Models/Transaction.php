<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Transaction extends Model
{
    protected $table ='transactions';
    protected $fillable = ['description','amount','category_id','account_id','user_id'];

    protected $hidden = [
        'account_id',
        'category_id',
        'updated_at',
    ];

    public function account(){
        
        return $this->hasOne(Account::class,'id','account_id');
    }

    public function category(){
        
        return $this->hasOne(Category::class,'id','category_id');
    }
}
