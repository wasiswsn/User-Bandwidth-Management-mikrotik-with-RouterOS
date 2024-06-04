<?php

namespace App\Models;

// use Illuminate\Contracts\Auth\MustVerifyEmail;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use Laravel\Sanctum\HasApiTokens;

class router extends Authenticatable
{
    use HasApiTokens, HasFactory, Notifiable;

    /**
     * The attributes that are mass assignable.
     *
     * @var string[]
     */
    protected $table = 'routers';
    protected $primaryKey = 'id';
    protected $fillable = [
        'id',
        'user_id',
        'address',
        'username', 
        'password',
    ];

    public function user()
    {
        return $this->belongsTo(User::class, 'user_id');
    }

    public function pemesanan(){
        return $this->hasMany('App\Models\pemesanan');
    }

    public function transaksi(){
        return $this->hasMany('App\Models\transaksi');
    }

    /**
     * The attributes that should be hidden for serialization.
     *
     * @var array
     */
}
