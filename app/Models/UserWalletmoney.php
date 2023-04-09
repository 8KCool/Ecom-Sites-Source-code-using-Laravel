<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class UserWalletmoney extends Model
{
    use HasFactory;
    protected $table = 'user_walletmoneys';
    protected $primaryKey = 'id';

    public $sortable = ['user_id',
                        'payment_method',
                        'created_at',
                        ];

    public function user()
	{
		return $this->belongsTo(User::class, 'user_id');
	}

}
