<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use Spatie\Activitylog\Traits\LogsActivity;

class Cospertes extends Model
{
    use HasFactory, SoftDeletes, LogsActivity; 

    protected static $logAttributes = ["*"];
    protected $table = 't_cprr';
    protected $primaryKey = 'fc_cprrcode';
    protected $guarded = ['type'];

    public function CprrCustomer(){
        return $this->hasMany(CprrCustomer::class,'fc_cprrcode','fc_cprrcode')->withTrashed();
    }
}
