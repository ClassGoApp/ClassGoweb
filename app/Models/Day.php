<?php

namespace App\Models;

use Carbon\Carbon;

class Day
{
    protected static $rows = [
        [
            'id' => 1,
            'week_day' => Carbon::SUNDAY,
            'short_key' => 'days.short_sunday',
            'name_key' => 'days.sunday',
        ],
        [
            'id' => 2,
            'week_day' => Carbon::MONDAY,
            'short_key' => 'days.short_monday',
            'name_key' => 'days.monday',
        ],
        [
            'id' => 3,
            'week_day' => Carbon::TUESDAY,
            'short_key' => 'days.short_tuesday',
            'name_key' => 'days.tuesday',
        ],
        [
            'id' => 4,
            'week_day' => Carbon::WEDNESDAY,
            'short_key' => 'days.short_wednesday',
            'name_key' => 'days.wednesday',
        ],
        [
            'id' => 5,
            'week_day' => Carbon::THURSDAY,
            'short_key' => 'days.short_thursday',
            'name_key' => 'days.thursday',
        ],
        [
            'id' => 6,
            'week_day' => Carbon::FRIDAY,
            'short_key' => 'days.short_friday',
            'name_key' => 'days.friday',
        ],
        [
            'id' => 7,
            'week_day' => Carbon::SATURDAY,
            'short_key' => 'days.short_saturday',
            'name_key' => 'days.saturday',
        ],
    ];

    public static function get($startDay = Carbon::SUNDAY)
    {
        $startPosition = array_search($startDay, array_column(self::$rows, 'week_day'));

        $days = array_merge(
            array_slice(self::$rows, $startPosition),
            array_slice(self::$rows, 0, $startPosition)
        );

        return array_map(function ($day) {
            return [
                'id' => $day['id'],
                'week_day' => $day['week_day'],
                'short_name' => __($day['short_key']),
                'name' => __($day['name_key']),
            ];
        }, $days);
    }
}