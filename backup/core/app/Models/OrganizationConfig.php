<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class OrganizationConfig extends Model
{
    use HasFactory;
    protected $table = 'organization_configs';
    protected $fillable = ['thankyou_message','company_name','logo','phone_number','tax_id'];
}
