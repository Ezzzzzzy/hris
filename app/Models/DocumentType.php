<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use App\Models\Document;

class DocumentType extends Model
{
    use SoftDeletes;

    protected $guarded = [];
	
	protected $dates = [
		'created_at',
		'updated_at',
		'deleted_at'
	];

	private $users = [
		'Jerome Agapay',
		'Rachelle Uy',
		'Neil Nato',
		'Nards Paragas',
		'Princess De Guzman',
		'Emerson Rivera',
		'Daryl Elvinson'
	];

	public function document()
	{
		return $this->hasMany(Document::class);
	}

	public static function filter($fields, $value)
	{
		if (!in_array('enabled', $fields)) {
			array_push($fields, 'enabled');
		}

		return DocumentType::where('enabled', $value)->select($fields);
	}

}
