<?php

namespace App\Models;

use Validator;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class School extends Model
{
    use SoftDeletes;

    protected $errors;

    protected $fillable = [
    	'school_name',
    	'school_type',
    	'degree',
    	'started_at',
    	'ended_at',
	];
	
	protected $dates = [
		'created_at',
		'updated_at',
		'deleted_at'
	];

	/** 
     *  rules for validating a request
     */
    private $rules = array(
    	'school_name' => 'required',
    	'school_type' => 'required',
    	'degree' 	  => 'required',
    	'started_at'  => 'required',
    	'ended_at' 	  => 'required'
    );

    /**
     * Validate array of a request
     * 
     * @param array
     * @return boolean
     */
    public function validate($data = [])
    {
        $v = Validator::make($data, $this->rules);

        if($v->fails()){
            $this->errors = $v->errors();
            return false;
        }else return true;
    }

    public function errors(){
        return $this->errors;
    }
}