<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Payment extends Model
{
    use HasFactory;
    protected $fillable = ['references_code','id_invoice','method','total_amount','fee_merchant','fee_customer','total_fee','amount_received','status'];
}
