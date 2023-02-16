<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Periode extends Model
{
    use HasFactory, SoftDeletes;

    const CREATED_AT = 'p_created_at';
    const UPDATED_AT = 'p_updated_at';
    const DELETED_AT = 'p_deleted_at';

    /**
     * The table associated with the model.
     *
     * @var string
     */
    protected $table = 'd_periode';

    /**
     * The primary key associated with the table.
     *
     * @var string
     */
    protected $primaryKey = 'p_id';

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = ['p_year', 'p_status'];
}
