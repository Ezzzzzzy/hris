<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use App\Models\BranchWorkHistory;
use Illuminate\Database\QueryException;

class EmploymentStatus extends Model
{
	use SoftDeletes;

	protected $hidden = [
		"created_at",
		"updated_at",
		"deleted_at"
	];

	protected $fillable = [
		"status_name",
		"color",
		"enabled",
		"type",
		"last_modified_by",
		"order"
	];

	protected $dates = [
		"created_at",
		"updated_at",
		"deleted_at"
	];

	public function branchWorkHistory()
	{
		return $this->hasOne(BranchWorkHistory::class);
	}

	public static function filter($fields, $value)
	{
		if (!in_array("enabled", $fields)) {
			array_push($fields, "enabled");
		}

		return EmploymentStatus::where("enabled", $value)->select($fields);
	}
}