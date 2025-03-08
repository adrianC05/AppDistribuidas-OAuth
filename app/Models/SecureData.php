<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class SecureData extends Model
{
    use HasFactory;

    protected $fillable = ['name', 'encrypted_data'];
}
