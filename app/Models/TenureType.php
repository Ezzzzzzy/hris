<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class TenureType extends Model
{
    use SoftDeletes;

    protected $guarded = [];
    protected $fillable = ['tenure_type', 'month_start_range', 'month_end_range', 'enabled'];

    protected $dates = [
        'created_at',
        'updated_at',
        'deleted_at'
    ];

    public function clientWorkHistory()
    {
        return $this->belongsTo(ClientWorkHistory::class);
    }

    public static function filter($fields, $value)
    {
        if (!in_array("enabled", $fields)) {
            array_push($fields, "enabled");
        }

        return TenureType::where("enabled", $value)->select($fields);
    }
}
