<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Client extends Model
{
    use HasFactory;
    protected $fillable= ['name','pic_name','code','address','phone','email'];

    public function invoices(){
        return $this->hasMany(Invoice::class, 'client_id');
    }
}
