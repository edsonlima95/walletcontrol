<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Wallet extends Model
{
    use HasFactory;

    protected $fillable = [
        'user_id',
        'name',
        'description',
        'signature'
    ];

    public function invoices()
    {
        return $this->belongsTo(Invoices::class, 'id', 'wallet_id');
    }

    public function income()
    {
        return $this->invoices()->where('type', 'income')->where('status', 'paid')->sum('value');
    }

    public function expense()
    {
        return $this->invoices()->where('type', 'expense')->where('status', 'paid')->sum('value');
    }


//
//    public function expense()
//    {
//        return $this->invoices()->where('status', 'paid')->sum('value');
//    }
}
