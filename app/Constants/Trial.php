<?php

namespace App\Constants;

use App\Traits\TrialTrait;

final class Trial
{
    use TrialTrait;

    const DEFAULT_TRIAL_EXPIRED_AT = 3; // 3 month
    const DEFAULT_TRIAL_MEMBER = 10;
    const TRIAL = 0;
    const APPROVED = 1;
    const TRIAL_MONTHS = [3, 6];
    const TRIAL_3_MONTH = 3;
    const TRIAL_6_MONTH = 6;
    const TRIAL_MEMBERS = [10, 20, 30];

    public static function getTrialExpired()
    {
        return TrialTrait::getTrialExpiredAt();
    }
}