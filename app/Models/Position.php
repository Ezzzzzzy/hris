<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

use App\Models\BranchWorkHistory;

class Position extends Model
{
    use SoftDeletes;

    protected $hidden = ['created_at', 'updated_at', 'deleted_at'];

    protected $guarded = [];

    protected $dates = ['created_at', 'updated_at', 'deleted_at'];

    public function branchWorkHistory()
    {
        return $this->hasOne(BranchWorkHistory::class);
    }

	public static function filter($fields, $value)
	{
		if (!in_array("enabled", $fields)) {
			array_push($fields, "enabled");
		}

		return Position::where("enabled", $value)->select($fields);
	}
}