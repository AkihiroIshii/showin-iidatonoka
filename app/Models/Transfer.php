<?php

namespace App\Models;

use Carbon\Carbon;
use Illuminate\Database\Eloquent\Model;

class Transfer extends Model
{
    private $weekdays = ['日', '月', '火', '水', '木', '金', '土'];

    // アクセサを追加
    public function getFormattedDayOfAbsence1Attribute()
    {
        if (!$this->day_of_absence_1) {
            return null;
        }

        $date = Carbon::parse($this->day_of_absence_1);
        $weekday = $this->weekdays[$date->dayOfWeek];

        return $date->format('n/j') . "($weekday)";
    }

    public function getFormattedDayOfAbsence2Attribute()
    {
        if (!$this->day_of_absence_2) {
            return null;
        }

        $date = Carbon::parse($this->day_of_absence_2);
        $weekday = $this->weekdays[$date->dayOfWeek];

        return $date->format('n/j') . "($weekday)";
    }

    public function getFormattedDayOfAbsence3Attribute()
    {
        if (!$this->day_of_absence_3) {
            return null;
        }

        $date = Carbon::parse($this->day_of_absence_3);
        $weekday = $this->weekdays[$date->dayOfWeek];

        return $date->format('n/j') . "($weekday)";
    }

    public function getFormattedAlternativeDay1Attribute()
    {
        if (!$this->alternative_day_1) {
            return null;
        }

        $date = Carbon::parse($this->alternative_day_1);
        $weekday = $this->weekdays[$date->dayOfWeek];

        return $date->format('n/j') . "($weekday)";
    }

    public function getFormattedAlternativeDay2Attribute()
    {
        if (!$this->alternative_day_2) {
            return null;
        }

        $date = Carbon::parse($this->alternative_day_2);
        $weekday = $this->weekdays[$date->dayOfWeek];

        return $date->format('n/j') . "($weekday)";
    }

    public function getFormattedAlternativeDay3Attribute()
    {
        if (!$this->alternative_day_3) {
            return null;
        }

        $date = Carbon::parse($this->alternative_day_3);
        $weekday = $this->weekdays[$date->dayOfWeek];

        return $date->format('n/j') . "($weekday)";
    }

    public function getFormattedTimeFromAbsence1Attribute()
    {
        return $this->time_from_absence_1
            ? Carbon::parse($this->time_from_absence_1)->format('G:i')
            : null;
    }

    public function getFormattedTimeFromAbsence2Attribute()
    {
        return $this->time_from_absence_2
            ? Carbon::parse($this->time_from_absence_2)->format('G:i')
            : null;
    }

    public function getFormattedTimeFromAbsence3Attribute()
    {
        return $this->time_from_absence_3
            ? Carbon::parse($this->time_from_absence_3)->format('G:i')
            : null;
    }

    public function getFormattedTimeToAbsence1Attribute()
    {
        return $this->time_to_absence_1
            ? Carbon::parse($this->time_to_absence_1)->format('G:i')
            : null;
    }

    public function getFormattedTimeToAbsence2Attribute()
    {
        return $this->time_to_absence_2
            ? Carbon::parse($this->time_to_absence_2)->format('G:i')
            : null;
    }

    public function getFormattedTimeToAbsence3Attribute()
    {
        return $this->time_to_absence_3
            ? Carbon::parse($this->time_to_absence_3)->format('G:i')
            : null;
    }

    public function getFormattedTimeFromAlternative1Attribute()
    {
        return $this->time_from_alternative_1
            ? Carbon::parse($this->time_from_alternative_1)->format('G:i')
            : null;
    }

    public function getFormattedTimeFromAlternative2Attribute()
    {
        return $this->time_from_alternative_2
            ? Carbon::parse($this->time_from_alternative_2)->format('G:i')
            : null;
    }

    public function getFormattedTimeFromAlternative3Attribute()
    {
        return $this->time_from_alternative_3
            ? Carbon::parse($this->time_from_alternative_3)->format('G:i')
            : null;
    }

    public function getFormattedTimeToAlternative1Attribute()
    {
        return $this->time_to_alternative_1
            ? Carbon::parse($this->time_to_alternative_1)->format('G:i')
            : null;
    }

    public function getFormattedTimeToAlternative2Attribute()
    {
        return $this->time_to_alternative_2
            ? Carbon::parse($this->time_to_alternative_2)->format('G:i')
            : null;
    }

    public function getFormattedTimeToAlternative3Attribute()
    {
        return $this->time_to_alternative_3
            ? Carbon::parse($this->time_to_alternative_3)->format('G:i')
            : null;
    }

    protected $fillable = [
        'user_id',
        'day_of_absence_1',
        'day_of_absence_2',
        'day_of_absence_3',
        'time_from_absence_1',
        'time_from_absence_2',
        'time_from_absence_3',
        'time_to_absence_1',
        'time_to_absence_2',
        'time_to_absence_3',
        'reason_of_absence_1',
        'reason_of_absence_2',
        'reason_of_absence_3',
        'alternative_day_1',
        'alternative_day_2',
        'alternative_day_3',
        'time_from_alternative_1',
        'time_from_alternative_2',
        'time_from_alternative_3',
        'time_to_alternative_1',
        'time_to_alternative_2',
        'time_to_alternative_3',
        'status',
    ];
}
