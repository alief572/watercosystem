<?php

class Stock_booking_rules
{
    // Stock and stock-card quantities use DOUBLE(...,0) in the existing database.
    public static function quantity($value, $allowNegative = false)
    {
        if (!is_scalar($value) || !is_numeric($value) || !is_finite((float)$value)
            || abs((float)$value) > 9007199254740991 || floor((float)$value) != (float)$value
            || (!$allowNegative && (float)$value < 0)) {
            throw new DomainException('Qty stok harus bilangan bulat yang valid dan tidak negatif.');
        }
        return (int)$value;
    }

    public static function reconcile($actual, $reserved)
    {
        $actual = self::quantity($actual);
        $reserved = self::quantity($reserved);
        if ($reserved > $actual) {
            throw new DomainException('Booking melebihi Qty Aktual; selesaikan konflik sebelum melanjutkan.');
        }
        return array('qty'=>$actual, 'qty_book'=>$reserved, 'qty_free'=>$actual-$reserved);
    }

    public static function release($actual, $reserved, $free, $requested)
    {
        $reserved = max(0, self::quantity($reserved, true));
        $released = min($reserved, self::quantity($requested));
        return self::reconcile($actual, $reserved-$released) + array('released'=>$released);
    }
}
