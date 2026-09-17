<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class BrandApplication extends Model
{
    protected $fillable = [
        'brand_name', 'contact_person', 'email', 'phone',
        'website', 'details', 'interest', 'message', 'status',
    ];

    public function scopePending($query)
    {
        return $query->where('status', 'pending');
    }
}
