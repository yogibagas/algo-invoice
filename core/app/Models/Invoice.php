<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\Crypt;

class Invoice extends Model
{
    use HasFactory;
    protected $fillable = ['no_inv','security_code','client_id','total','due_date','status','notes'];

    public function client(){
        return $this->belongsTo(Client::class);
    }
    public function items(){
        return $this->hasMany(InvoiceDetail::class,'invoice_id');
    }
    public function payments(){
        return $this->hasMany(Payment::class, 'invoice_id');
    }
}
