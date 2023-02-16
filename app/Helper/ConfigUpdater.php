<?php

namespace App\Helper;

use App\Models\MailSetting;

trait ConfigUpdater
{
    protected function updateMailConfig()
    {
        $mailSettings = MailSetting::get()->mapWithKeys(function ($item) {
            return ['mail.mailers.smtp.' . $item->key => $item->value];
        })->toArray();

        config($mailSettings);
    }
}