<?php
/**
 * @package     Work-Learn
 * @author      Ron Tayler
 * @copyright   2020
 */

namespace calc;
class Car
{
    public function getAge($productionYear, $productionMonth = 0)
    {
        $age = date('Y') - $productionYear;
        if(!($productionMonth >= 0 && $productionMonth < date('n')))
        {
            $age--;
        }
        return $age;
    }
    public function getPower($code)
    {
        if(in_array($code,['ZE0','AZE0','ZEO','AZEO']))
        {
            return 109;
        }
        else
        {
            return 99;
        }
    }
}