<?php
namespace App\Traits;

use Carbon\Carbon;
use App\Constants\Trial;

trait TrialTrait
{
    public static function getTrialExpiredAt()
    {
        $now = Carbon::now(); 
        $expiredAt = $now->addMonths(Trial::DEFAULT_TRIAL_EXPIRED_AT)->toDateTimeString();

        return $expiredAt;
    }
}