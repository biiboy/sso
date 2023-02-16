<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Kpi extends Model
{
    use HasFactory;

    protected $table = 'a_kpi';
    protected $primaryKey = 'k_id';
    const CREATED_AT = 'k_created_at';
    const UPDATED_AT = 'k_updated_at';

    protected $fillable = [
        'k_id',
        'k_collaboration',
        'k_status_id',
        'k_label',
        'k_goal',
        'k_targetdate',
        'k_coordinator_id',
        'k_leader_id',
        'k_manager_id',
        'k_selfassessment',
        'k_created_by',
        'k_specialist_id',
        'k_coordinatorfinalresult',
        'k_leaderfinalresult',
        'k_managerfinalresult',
        'k_created_at',
        'k_updated_at',
        'k_completed_spec',
        'k_completed_coor',
        'k_completed_lead',
        'k_completed_manager',
        'k_supplement',
        'k_assessment',
        'k_assessment_lead',
        'k_assessment_manager',
        'k_justification',
        'k_justification_manager',
        'k_justification_lead',
        'k_justification_coor',
        'k_site',
        'k_finalresult',
        'k_unit',
        'k_supplement_lead',
        'k_supplement_manager',
        'k_finalresult_text',
        'k_collab_assets',
        'k_collab_helpdesk',
        'k_collab_support',
        'k_approval_coor',
        'k_approval_lead',
        'k_approval_manager',
        'k_reject_coor',
        'k_reject_lead',
        'k_reject_manager'
    ];

    public function kpid()
    {
        return $this->hasMany(Kpid::class, 'kd_kpi_id', 'k_id');
    }
}
