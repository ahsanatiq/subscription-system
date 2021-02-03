<?php

namespace Domain;

use Carbon\Carbon;
use Carbon\CarbonTimeZone;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class OS extends Model
{
    use SoftDeletes;

    protected $table = 'operating_systems';
    const GOOGLE_PLATFORM = 'android';
    const GOOGLE_PLATFORM_TIMEZONE = 'UTC';
    const APPLE_PLATFORM = 'ios';
    const APPLE_PLATFORM_TIMEZONE = '-06:00';
    const PLATFORM_DATETIME_FORMAT = 'Y-m-d H:i:s';

    public static function getList()
    {
        return [self::GOOGLE_PLATFORM, self::APPLE_PLATFORM];
    }

    public function handleDateTime($datetime)
    {

        if ($this->name == self::APPLE_PLATFORM) {
            $tz = CarbonTimeZone::create(self::APPLE_PLATFORM_TIMEZONE);
            $datetime = Carbon::createFromFormat(self::PLATFORM_DATETIME_FORMAT, $datetime, $tz);
            $datetime->tz = 'UTC';
        } else {
            $datetime = Carbon::createFromFormat(self::PLATFORM_DATETIME_FORMAT, $datetime);
        }

        return $datetime;
    }
}
