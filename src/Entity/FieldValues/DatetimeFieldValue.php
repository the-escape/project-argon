<?php

namespace Escape\Argon\Entity\FieldValues;

use Carbon\Carbon;

/**
 * Class DatetimeFieldValue
 *
 * @property-read int $year
 * @property-read int $yearIso
 * @property-read int $month
 * @property-read int $day
 * @property-read int $hour
 * @property-read int $minute
 * @property-read int $second
 * @property-read int $timestamp seconds since the Unix Epoch
 * @property-read DateTimeZone $timezone the current timezone
 * @property-read DateTimeZone $tz alias of timezone
 * @property-read integer $micro
 * @property-read integer $dayOfWeek 0 (for Sunday) through 6 (for Saturday)
 * @property-read integer $dayOfYear 0 through 365
 * @property-read integer $weekOfMonth 1 through 5
 * @property-read integer $weekOfYear ISO-8601 week number of year, weeks starting on Monday
 * @property-read integer $daysInMonth number of days in the given month
 * @property-read integer $quarter the quarter of this instance, 1 - 4
 * @property-read integer $offset the timezone offset in seconds from UTC
 * @property-read integer $offsetHours the timezone offset in hours from UTC
 * @property-read boolean $dst daylight savings time indicator, true if DST, false otherwise
 * @property-read boolean $local checks if the timezone is local, true if local, false otherwise
 * @property-read boolean $utc checks if the timezone is UTC, true if UTC, false otherwise
 * @property-read string  $timezoneName
 * @property-read string  $tzName
 */
class DatetimeFieldValue extends AbstractFieldValue implements \IteratorAggregate
{
    /**
     * @return Carbon
     */
    public function getValue()
    {
        if ($this->isEmpty()) {
            return null;
        }
        $data = is_array($this->data) ? $this->data[0] : $this->data;
        $date = Carbon::createFromFormat('Y-m-d H:i:s', $data);
        return $date;
    }

    public function getIterator()
    {
        if ($this->isEmpty()) {
            $data = [''];
        } else {
            $data = $this->getValue();
        }

        if (!is_array($data)) {
            $data = [$data];
        }

        return new \ArrayIterator($data);
    }

    public function isUnset()
    {
        return $this->data == null;
    }

    /** Carbon imitation functions */
    public function __toString()
    {
        if ($this->isEmpty()) {
            return '';
        }
        return $this->getValue()->__toString();
    }

    public function __get($name)
    {
        switch ($name) {
            case 'year':
            case 'yearIso':
            case 'month':
            case 'day':
            case 'hour':
            case 'minute':
            case 'second':
            case 'micro':
            case 'dayOfWeek':
            case 'dayOfYear':
            case 'weekOfMonth':
            case 'weekOfYear':
            case 'daysInMonth':
            case 'timestamp':
            case 'quarter':
            case 'dst':
            case 'local':
            case 'utc':
            case 'timezone':
            case 'tz':
            case 'timezoneName':
            case 'tzName':
            case 'offset':
            case 'offsetHours':
                if ($this->isEmpty()) {
                    return "";
                }
                return $this->getValue()->$name;
            default:
                throw new \InvalidArgumentException("Property '{$name}' doesn't exist");
        }
    }

    public function toDateTimeString()
    {
        if ($this->isEmpty()) {
            return '';
        }
        return $this->getValue()->__toString();
    }

    public function toDateString()
    {
        if ($this->isEmpty()) {
            return '';
        }
        return $this->getValue()->toDateString();
    }

    public function toFormattedDateString()
    {
        if ($this->isEmpty()) {
            return '';
        }
        return $this->getValue()->toFormattedDateString();
    }

    public function toTimeString()
    {
        if ($this->isEmpty()) {
            return '';
        }
        return $this->getValue()->toTimeString();
    }

    public function toDayDateTimeString()
    {
        if ($this->isEmpty()) {
            return '';
        }
        return $this->getValue()->toDayDateTimeString();
    }

    public function format($format)
    {
        if ($this->isEmpty()) {
            return "";
        }
        return $this->getValue()->format($format);
    }

    protected function standardise($value)
    {
        if ($value instanceof static) {
            return $value->getValue();
        } else {
            return $value;
        }
    }

    public function eq($other)
    {
        if ($this->isEmpty()) {
            throw new \RuntimeException("Empty datetime value. Carbon time comparison not feasible.");
        }
        return $this->getValue()->eq($this->standardise($other));
    }

    public function ne($other)
    {
        if ($this->isEmpty()) {
            throw new \RuntimeException("Empty datetime value. Carbon time comparison not feasible.");
        }
        return $this->getValue()->ne($this->standardise($other));
    }

    public function gt($other)
    {
        if ($this->isEmpty()) {
            throw new \RuntimeException("Empty datetime value. Carbon time comparison not feasible.");
        }
        return $this->getValue()->gt($this->standardise($other));
    }

    public function gte($other)
    {
        if ($this->isEmpty()) {
            throw new \RuntimeException("Empty datetime value. Carbon time comparison not feasible.");
        }
        return $this->getValue()->gte($this->standardise($other));
    }

    public function lt($other)
    {
        if ($this->isEmpty()) {
            throw new \RuntimeException("Empty datetime value. Carbon time comparison not feasible.");
        }
        return $this->getValue()->lt($this->standardise($other));
    }

    public function lte($other)
    {
        if ($this->isEmpty()) {
            throw new \RuntimeException("Empty datetime value. Carbon time comparison not feasible.");
        }
        return $this->getValue()->lte($this->standardise($other));
    }

    public function between($first, $second)
    {
        if ($this->isEmpty()) {
            throw new \RuntimeException("Empty datetime value. Carbon time comparison not feasible.");
        }
        return $this->getValue()->between($this->standardise($first), $this->standardise($second));
    }
}
