<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use Spatie\Activitylog\Traits\LogsActivity;
use App\Blameable;

class StockSupplier extends Model
{
    use HasFactory, Blameable, SoftDeletes, LogsActivity;

    protected static $logAttributes = ["*"];
    public $incrementing = false;

    protected $table = 't_stocksupplier';
    protected $primaryKey = ['fc_divisioncode', 'fc_branch', 'fc_stockcode', 'fc_barcode', 'fc_suppliercode'];
    protected $guarded = [];
    protected $appends = [];

    public function scopeActive($query){
        $query->where('status', 1);
    }
}
