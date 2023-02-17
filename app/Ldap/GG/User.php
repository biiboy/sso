<?php

namespace App\Ldap\GG;

use LdapRecord\Models\Model;

class User extends Model
{
    protected $connection = 'default';
    /**
     * The object classes of the LDAP model.
     *
     * @var array
     */
    public static $objectClasses = [];
}
