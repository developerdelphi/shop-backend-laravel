<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Database\Eloquent\Model;

class Order extends Model
{
    use HasFactory, SoftDeletes;

    protected $fillable = ['user_id', 'total', 'status'];

    protected $casts = [
        'created_at' => 'datetime:d-m-Y',
    ];

    public function user()
    {
        return  $this->belongsTo(User::class);
    }
}
