<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use LdapRecord\Laravel\Auth\AuthenticatesWithLdap;
use LdapRecord\Laravel\Auth\LdapAuthenticatable;

class Member extends Authenticatable implements LdapAuthenticatable
{
    use Notifiable, AuthenticatesWithLdap;

    const CREATED_AT = 'm_created_at';
    const UPDATED_AT = 'm_updated_at';

    /**
     * The table associated with the model.
     *
     * @var string
     */
    protected $table = 'd_mem';

    /**
     * The primary key associated with the table.
     *
     * @var string
     */
    protected $primaryKey = 'm_id';

    /**
     * The attributes that should be hidden for serialization.
     *
     * @var array<int, string>
     */
    protected $hidden = ['password'];

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'm_code', 'm_username', 'm_site', 'm_password', 'm_name',
        'm_email', 'm_manager', 'm_lead', 'm_coordinator', 'm_specialist',
        'm_lastlogin', 'm_lastlogout', 'm_gender', 'm_status', 'm_unit',
        'm_access', 'm_flag',
    ];

    public function scopeActive($query)
    {
        $query->where('m_status', 'aktif');
    }

    public function getLdapDomainColumn()
    {
        return 'domain';
    }

    public function getLdapGuidColumn()
    {
        return 'guid';
    }
}
