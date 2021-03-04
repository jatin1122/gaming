<?php

function currency(float $price)
{
    if (function_exists('money_format')) {
        return "£" . money_format("%i", $price);
    } else {
        return "£" . $price;
    }
}