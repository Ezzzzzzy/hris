<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use App\Models\{
    BranchWorkHistory,
    Client,
    Member,
    location,
    TenureType
};
class ClientWorkHistory extends Model
{
    use SoftDeletes;

    protected $fillable = [ 
        'employee_id',
        'date_start',
        'date_end',
        'status',
    ];

    public function client()
    {
        return $this->belongsTo(Client::class);
    }

    public function member()
    {
        return $this->belongsTo(Member::class, 'member_id');
    }

    public function branchWorkHistory()
    {
        return $this->hasMany(BranchWorkhistory::class);
    }

    public function latestBranchWorkHistory()
    {
        return $this->hasMany(BranchWorkhistory::class)->orderBy("id", "DESC");
    }
    
    public function location()
    {
        return $this->hasManyThrough(Location::class, BranchWorkhistory::class);
    }

    public function tenureType()
    {
        return $this->belongsTo(TenureType::class);
    }
}