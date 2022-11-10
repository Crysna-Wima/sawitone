<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use Spatie\Activitylog\Traits\LogsActivity;
use App\Blameable;
use App\Traits\CompositeKey;

class TransaksiType extends Model
{
    use HasFactory, Blameable, SoftDeletes, LogsActivity, CompositeKey;

    protected static $logAttributes = ["*"];

    protected $table = 't_trxtype';
    protected $primaryKey = 'fc_kode';
    // protected $primaryKey = ['fc_trx', 'fc_kode'];
    public $incrementing = false;
    protected $fillable = ['fc_trx', 'fc_kode', 'fv_description'];
    protected $appends = [];

    public function scopeActive($query){
        $query->where('status', 1);
    }
}
