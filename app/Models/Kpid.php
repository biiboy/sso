<?php

namespace App\Models;

use Carbon\Carbon;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Kpid extends Model
{
    use HasFactory;

    protected $table = 'a_kpid';
    protected $primaryKey = 'kd_kpi_id';
    const CREATED_AT = 'kd_created_at';
    const UPDATED_AT = 'kd_updated_at';

    protected $fillable = [
        'kd_id',
        'kd_kpi_id',
        'kd_tacticalstep',
        'kd_measure_id',
        'kd_duedate',
        'kd_status_id',
        'kd_created_at',
        'kd_result_id',
        'kd_updated_at',
        'kd_comment',
        'flag_due_date_checked',
        'flag_ts_checked',
        'kd_completed_date',
        'kd_value'
    ];

    public function tahun()
    {
        return Carbon::parse($this->kd_duedate)->format('Y');
    }
}
