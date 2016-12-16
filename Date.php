<?php namespace Utils;

class Date
{

    /**
     * @param $previousMonths Integer
     * @param $nextMonths     Integer
     * @return \DatePeriod
     */
    static function createMonthRange($previousMonths, $nextMonths)
    {
        $nextMonths    = $nextMonths + 1;
        $rangeStart    = new \DateTimeImmutable("first day of -$previousMonths months");
        $rangeEnd      = new \DateTimeImmutable("first day of +$nextMonths months");
        $monthInterval = new \DateInterval('P1M');
        $rangeIterator = new \DatePeriod($rangeStart, $monthInterval, $rangeEnd);
        $months        = iterator_to_array($rangeIterator);
        $result        = array_map(function ($month) {
            return self::createMonth($month);
        }, $months);

        return $result;
    }

    static function createMonth($month)
    {
        $daysInMonth = cal_days_in_month(CAL_GREGORIAN, $month->format('m'), $month->format('Y'));
        $firstMonday = $month->modify('first monday');
        $size        = (8 - intval($firstMonday->format('d'))) + $daysInMonth;
        $result      = [
            'year'      => $month->format('Y'),
            'month'     => $month->format('m'),
            'localised' => date_i18n('F', $month->getTimestamp()),
            'days'      => array_chunk(array_pad(array_map(function ($day) {
                return sprintf('%02d', $day);
            }, range(1, $daysInMonth)), -$size, 'x'), 7)
        ];
        return $result;
    }

    static function formatDateTime($date = null)
    {
        return date('Y-m-d H:i', strtotime($date) ?: time());
    }

    static function formatDate($time = null)
    {
        return date('Y-m-d', strtotime($time) ?: time());
    }
}
