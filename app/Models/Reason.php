<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Reason extends Model
{
    use SoftDeletes;

    protected $guarded = [];

    protected $dates = [
        'created_at',
        'updated_at',
        'deleted_at'
    ];

    protected $hidden = [
        'created_at',
        'updated_at',
        'deleted_at'
    ];

    private $users = [
        'Nards Paragas',
        'Ezra Paz',
        'Neil Nato',
        'Daryl Sinon',
        'Princess Ramirez',
        'Jerome Agapay'
    ];

    public static function getAll()
    {
        $reasons = new static;
        return $reasons::all(['id', 'reason', 'remarks', 'enabled', 'last_modified_by', 'order']);
    }

    public function search($keyword)
    {
        $value = Reason::where("reason", "LIKE", "%$keyword%")
            ->orWhere('id', "LIKE", "%$keyword%");

        return $value;
    }
    
    public static function filter($fields, $value)
    {
        if (!in_array('enabled', $fields)) {
            array_push($fields, 'enabled');
        }

        return Reason::where('enabled', $value)->select($fields);
    }

    public function sortBy($value)
    {
        try {
            $status = Reason::orderBy($value)->get();
            return $status;
        } catch (QueryException $e) {
            return false;
        }
    }
}
