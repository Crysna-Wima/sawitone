<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use Spatie\Activitylog\Traits\LogsActivity;
use Illuminate\Database\Eloquent\Builder;
use App\Blameable;
use App\Traits\CompositeKey;

class Invstore extends Model
{
    use HasFactory, Blameable, LogsActivity, CompositeKey;

    protected static $logAttributes = ["*"];

    protected $table = 't_invstore';
    protected $primaryKey = 'fc_barcode';
    public $incrementing = false;
    protected $guarded = ['type'];


    public function stock(){
        return $this->belongsTo(Stock::class, 'fc_stockcode', 'fc_stockcode')->withTrashed();
    }

    // relasi dengan tabel dodtl
    public function dodtl(){
        return $this->hasMany(DoDetail::class, 'fc_barcode', 'fc_barcode');
    }

 

    
}
