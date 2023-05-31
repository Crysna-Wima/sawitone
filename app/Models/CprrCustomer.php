<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use Spatie\Activitylog\Traits\LogsActivity;

class CprrCustomer extends Model
{
    use HasFactory, SoftDeletes, LogsActivity;

    protected static $logAttributes = ["*"];
    protected $table = 't_cprrcustomer';
    protected $primaryKey = 'id';
    protected $guarded = ['type'];

    public function  Cospertes(){
        return $this->belongsTo(Cospertes::class,'fc_cprrcode','fc_cprrcode')->withTrased();
    }

    public function Customer(){
        return $this->belongsTo(Customer::class, 'fc_membercode', 'fc_membercode')->withTrashed();
    }
}
