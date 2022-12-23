<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use Spatie\Activitylog\Traits\LogsActivity;
use Illuminate\Database\Eloquent\Builder;
use App\Blameable;
use App\Traits\CompositeKey;

class TempSoDetail extends Model
{
    use HasFactory, Blameable, SoftDeletes, LogsActivity, CompositeKey;

    protected static $logAttributes = ["*"];

    protected $table = 't_tempsodtl';
    protected $primaryKey = 'fn_sorownum';
    public $incrementing = false;
    protected $guarded = ['type'];
    protected $appends = ['warehouse_desc'];

    public function getWarehouseDescAttribute(){
        return $this->attributes['fc_warehousecode'] == 'NO GUDANG' ? '-' : $this->warehouse->fc_rackname;
    }

    public function branch(){
        return $this->belongsTo(TransaksiType::class, 'fc_branch', 'fc_kode')->withTrashed();
    }

    public function stock(){
        return $this->belongsTo(Stock::class, 'fc_barcode', 'fc_barcode')->withTrashed();
    }

    public function warehouse(){
        return $this->belongsTo(Warehouse::class, 'fc_warehousecode', 'fc_warehousecode')->withTrashed();
    }
}
