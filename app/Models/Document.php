<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

use App\Models\{
	Member,
	DocumentType
};
class Document extends Model
{
    use SoftDeletes;

    protected $fillable = [
    	'document_name',
    	'path',
    	'enabled',
	];
	
	protected $date = [
		'created_at',
		'updated_at',
		'deleted_at'
	];

	public function member()
	{
		return $this->belongsTo(Member::class);
	}

	public function documentType()
	{
		return $this->belongsTo(DocumentType::class);
	}
}
