<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use Spatie\Activitylog\Traits\LogsActivity;
use App\Blameable;

class Stock extends Model
{
    use HasFactory, Blameable, SoftDeletes, LogsActivity;

    protected static $logAttributes = ["*"];
    public $incrementing = false;

    protected $table = 't_stock';
    protected $primaryKey = ['fc_divisioncode', 'fc_branch', 'fc_stockcode'];
    protected $guarded = [];
    protected $appends = [];

    public function scopeActive($query){
        $query->where('status', 1);
    }

    public function branch(){
        return $this->belongsTo(TransaksiType::class, 'fc_branch', 'fc_kode');
    }

    public function brand(){
        return $this->belongsTo(TransaksiType::class, 'fc_brand', 'fc_brand');
    }

    public function group(){
        return $this->belongsTo(TransaksiType::class, 'fc_group', 'fc_group');
    }

    public function subgroup(){
        return $this->belongsTo(TransaksiType::class, 'fc_subgroup', 'fc_subgroup');
    }

    public function type_stock1(){
        return $this->belongsTo(TransaksiType::class, 'fc_typestock1', 'fc_kode');
    }

    public function type_stock2(){
        return $this->belongsTo(TransaksiType::class, 'fc_typestock2', 'fc_kode');
    }
}
