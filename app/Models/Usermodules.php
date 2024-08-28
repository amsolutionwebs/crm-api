<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Usermodules extends Model
{
    use HasFactory;
    
     protected $fillable = [
        'employee_id',
        'module_id',
        'add',
        'view',
        'edit',
        'delete',
        'status',
    ];
}

