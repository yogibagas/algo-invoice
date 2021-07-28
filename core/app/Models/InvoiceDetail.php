<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class InvoiceDetail extends Model
{
    use HasFactory;
    protected $fillable = [
        'invoice_id','item_name','qty_type','qty','price','total','adjustment','item_note'
    ];

    public function invoice(){
        return $this->belongsTo(Invoice::class);
    }
}
