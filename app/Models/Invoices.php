<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Invoices extends Model
{
    use HasFactory;

    protected $fillable = [
        'user_id',
        'wallet_id',
        'category_id',
        'invoice_of',
        'description',
        'type',
        'value',
        'currency',
        'due_at',
        'repeat_when',
        'period',
        'enrollments',
        'enrollment_of',
        'status'
    ];

    //RELACIONAMENTOS
    public function category()
    {
        return $this->hasOne(Category::class, 'id', 'category_id');
    }

    //MUTATOR
    public function setValueAttribute($value)
    {
        $this->attributes['value'] = floatval($this->convertStringToDouble($value));
    }

    public function getValueAttribute($value)
    {
        return number_format($value, 2, ',', '.');
    }

    public function convertStringToDouble($param)
    {
        return str_replace(',', '.', str_replace('.', '', $param));
    }

}
