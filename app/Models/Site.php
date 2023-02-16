<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Site extends Model
{
    use HasFactory;

    const CREATED_AT = 's_created_at';
    const UPDATED_AT = 's_updated_at';

    /**
     * The table associated with the model.
     *
     * @var string
     */
    protected $table = 'd_site';

    /**
     * The primary key associated with the table.
     *
     * @var string
     */
    protected $primaryKey = 's_id';

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = ['s_name'];

    public function members()
    {
        return $this->hasMany(Member::class, 'm_site');
    }
}
