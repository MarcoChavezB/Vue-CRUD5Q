<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Hotel extends Model
{ 
    protected $filleable = ['id', 'name', 'location', 'cellphone', "website", "image", "zone", "zone_name", "created_at", "updated_at"];
    use HasFactory;
}
