<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class SettingRole extends Model
{
    use HasFactory;

    protected $table = 'setting_role';
    protected $guarded = ['id'];
}
