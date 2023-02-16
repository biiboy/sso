<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Unit extends Model
{
    use HasFactory, SoftDeletes;

    const CREATED_AT = 'u_created_at';
    const UPDATED_AT = 'u_updated_at';
    const DELETED_AT = 'u_deleted_at';

    /**
     * The table associated with the model.
     *
     * @var string
     */
    protected $table = 'd_unit';

    /**
     * The primary key associated with the table.
     *
     * @var string
     */
    protected $primaryKey = 'u_id';

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = ['u_name', 'u_site', 'u_flag', 'u_role', 'u_name_header'];

    public function accessMembers()
    {
        return $this->hasMany(Member::class, 'm_access');
    }

    public function unitMembers()
    {
        return $this->hasMany(Member::class, 'm_unit');
    }

    public function roleMenus()
    {
        return $this->hasMany(RoleMenu::class, 'role_id', 'u_role');
    }
}
