<?php

if (!function_exists('maskPhoneNumber')) {
    /**
     * Mask a phone number, showing only the first 2 and last 2 digits.
     *
     * @param string $phone
     * @return string
     */
    function maskPhoneNumber($phone)
    {
        if (strlen($phone) <= 8) {
            return $phone;
        }

        $firstTwo = substr($phone, 0, 5);

        $lastTwo = substr($phone, -2);

        $masked = $firstTwo . str_repeat('*', strlen($phone) - 4) . $lastTwo;

        return $masked;
    }
}