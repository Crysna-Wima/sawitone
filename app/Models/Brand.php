<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use Spatie\Activitylog\Traits\LogsActivity;
use App\Blameable;
use App\Traits\CompositeKey;

class Brand extends Model
{
    use HasFactory, Blameable, SoftDeletes, LogsActivity, CompositeKey;

    protected static $logAttributes = ["*"];

    protected $table = 't_brand';
    protected $primaryKey = ['fc_brand', 'fc_group', 'fc_subgroup'];
    public $incrementing = false;
    protected $guarded = [];
    protected $appends = [];

    public function branch(){
        return $this->belongsTo(TransaksiType::class, 'fc_branch', 'fc_kode');
    }
}
