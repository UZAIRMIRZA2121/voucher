<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class BusinessOwner extends Model
{
    use HasFactory;

    protected $fillable = ['name', 'customer_group_id'];

    protected $casts = [
        'customer_group_id' => 'array', // Cast JSON to array
    ];
 
    public function groupCustomers()
    {
        return $this->hasMany(GroupCustomer::class);
    }
}
