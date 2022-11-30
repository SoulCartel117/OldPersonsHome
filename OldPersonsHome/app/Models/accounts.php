<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class accounts extends Model
{
    use HasFactory;
    public $timestamps = false;
    protected $fillable = [
        'roleID',
        'FName',
        'LName',
        'Email',
        'phNo',
        'password',
        'DOB'
    ];
}
