<?php

if (!function_exists("money_format")) {
    /**
     * format a number as currency
     *
     * @param float $value
     * @return string
     */
    function money_format($value)
    {
        if($value)
        {
            return "R$ " . number_format($value, 2, ",", ".");
        }
        return "R$ 0";
    }
}

if (!function_exists("phone_format")) {
    /**
     * format a string as phone
     *
     * @param string $value
     * @return string
     */
    function phone_format($value): string
    {
        switch (strlen($value)) {
            case 8:
                return substr($value, 0, 4) . "-" . substr($value, 4);
                break;
            case 9:
                return substr($value, 0, 5) . "-" . substr($value, 5);
                break;
            case 10:
                return "(".substr($value, 0, 2) . ") " . substr($value, 2, 4) . "-" . substr($value, 6);
                break;
            case 11:
                return "(".substr($value, 0, 2) . ") " . substr($value, 2, 5) . "-" . substr($value, 7);
                break;
        }
        return (empty($value) ? "" : $value);
    }
}

if (!function_exists("money_unformat")) {
    /**
     * unformat a money-formatted string
     *
     * @param string $value
     * @return string
     */
    function money_unformat($value)
    {
        if($value)
        {
            $value = preg_replace("/[^\d\.\,]/", "", $value);
            $value = str_replace(".", "", $value);
            $value = str_replace(",", ".", $value);    
        }
        return $value;
    }
}