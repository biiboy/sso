<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class MailSetting extends Model
{
    use HasFactory;
    protected $table = 'mail_settings';

    protected $fillable = ['key', 'value'];

    public function scopeGetRecordForKey($query, $key)
    {
        return $query->where('key', '=', $key);
    }
}
