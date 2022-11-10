<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use Spatie\Activitylog\Traits\LogsActivity;
use App\Blameable;

class TransaksiType extends Model
{
    use HasFactory, Blameable, SoftDeletes, LogsActivity;

    protected static $logAttributes = ["*"];
    public $incrementing = false;

    protected $table = 't_trxtype';
    protected $primaryKey = ['fc_trx', 'fc_kode'];
    protected $fillable = ['fc_trx', 'fc_kode', 'fv_description'];
    protected $appends = [];

    public function scopeActive($query){
        $query->where('status', 1);
    }
}
