<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use App\Models\BranchWorkHistory;

class DisciplinaryAction extends Model
{
    use SoftDeletes;

    protected $fillable = [
        'date_of_incident',
        'incident_report',
        'date_of_notice_to_explain',
        'date_of_explanation',
        'decision',
        'date_of_decision',
        'status',
    ];

    protected $dates = [
        'created_at',
        'updated_at',
        'deleted_at'
    ];

    public function branchWorkhistory()
    {
        return $this->belongsTo(BranchWorkHistory::class, 'branch_work_history_id');
    }

    public function create($bwh_id, $attributes = [])
    {
        $bwh = BranchWorkHistory::find($bwh_id);
        $this->branchWorkHistory()->associate($bwh);

        $this->fill($attributes);
        $this->save();
        return $this;
    }

    public function getDisciplinaryAction($id)
    {
        $disciplinaryAction = DisciplinaryAction::get([
            'id',
            'date_of_incident',
            'incident_report',
            'date_of_notice_to_explain',
            'date_of_explanation',
            'decision',
            'date_of_decision',
            'status',
            'branch_work_history_id'
        ])
        ->where('id', $id);
        return $disciplinaryAction;
    }
}
