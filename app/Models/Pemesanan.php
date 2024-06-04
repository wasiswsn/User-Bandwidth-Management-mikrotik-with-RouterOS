<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class pemesanan extends Model
{
    use HasFactory;

    protected $table = 'pemesanan';
    protected $primaryKey = 'id';
    protected $fillable = ['id', 'user_id', 'profile', 'limit', 'total', 'bukti_bayar', 'jumlah', 'status'];

    public function router()
    {
        return $this->belongsTo(Router::class, 'router_id');
    }
}
