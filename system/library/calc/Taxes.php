<?php
/**
 * @package     Work-Learn
 * @author      Ron Tayler
 * @copyright   2020
 */

namespace calc;
class Taxes
{
    public $isFizLico;
    public $fuelType;
    public $engineCapacity;
    public $carAge;
    public $rubEurRate;


    public function getNDS($sum)
    {
        if($this->fuelType === 'electro'){
            if($this->isFizLico && $this->carAge < 3)
            {
                return 0;
            }
            return $sum*0.2;
        }
        else{
            return $this->isFizLico ? 0 : $sum*0.2;
        }


    }

    public function getEdiniyNalogFizLic($carPrice)
    {
        $carPriceEUR = $carPrice/$this->rubEurRate;
        if($this->fuelType === 'electro'){
            if(!$this->isFizLico || $this->carAge > 3){
                return 0;
            }
            return $carPriceEUR > 8500 ? $carPrice*0.48 : $carPrice*0.54;
        }
        else
        {
            return 0;
        }
    }
	
    public function getPoshlina($carPrice)
    {
//		$this->isFizLico = true;
        if($this->fuelType === 'electro'){
//            return ($this->carAge < 3 && $this->isFizLico) ? 0 : $carPrice*0.15;
            return 0;
        }
        else {

            //for gasoline and diesel is the same
            if ($this->isFizLico && $this->carAge < 3) {
                $carPriceEUR = $carPrice / $this->rubEurRate;
                $percentage = $carPrice * ($carPriceEUR < 8500 ? 54 : 48) / 100;
                $capacityRateEurTable = [
                    '8500' => 2.5,
                    '16700' => 3.5,
                    '42300' => 5.5,
                    '84500' => 7.5,
                    '169000 ' => 15,
                    '2000000' => 20, //car price more then 169000 EUR
                ];
                foreach (array_keys($capacityRateEurTable) as $upTo) {
                    if ($this->$carPriceEUR > $upTo) {
                        continue;
                    } else {
                        $coeff = $capacityRateEurTable[$upTo];
                        break;
                    }
                }
                return max($percentage, ($this->engineCapacity * $coeff / $this->rubEurRate));
            }
            else if ($this->isFizLico && $this->carAge > 3) {
                $capacityRateEurTable = [
                    '1000' => 1.5,
                    '1500' => 1.7,
                    '1800' => 2.5,
                    '2300' => 2.7,
                    '3000' => 3,
                    '2000000' => 3.6, //car enginecapacity more then 3001 cm^3
                ];
                $capacityRateEurTable2 = [
                    '1000' => 3,
                    '1500' => 3.2,
                    '1800' => 3.5,
                    '2300' => 4.8,
                    '3000' => 5,
                    '2000000' => 5.7, //car enginecapacity more then 3001 cm^3
                ];
                $table = $this->carAge < 5 ? $capacityRateEurTable : $capacityRateEurTable2;
                foreach (array_keys($table) as $upTo) {
                    if ((int)$this->engineCapacity > (int)$upTo) {
                        continue;
                    } else {
                        $coeff = $table[$upTo];
                        break;
                    }
                }
                return $this->engineCapacity * $coeff * $this->rubEurRate;
            }
            else if(!$this->isFizLico)
            {
                $capacityRateEurTableUpTo3yo = [
                    '1000' => 0.63,
                    '1500' => 0.73,
                    '1800' => 0.83,
                    '2300' => 1.2,
                    '3000' => 1.2,
                    '2000000' => 1.57, //car enginecapacity more then 3001 cm^3
                ];
                $capacityRateEurTable3to7yo = [
                    '1000' => 0.45,
                    '1500' => 0.45,
                    '1800' => 0.45,
                    '2300' => 0.55,
                    '3000' => 0.55,
                    '2000000' => 1, //car enginecapacity more then 3001 cm^3
                ];
                $capacityRateEurTableMoreThan7yo = [
                    '1000' => 1.4,
                    '1500' => 1.5,
                    '1800' => 1.6,
                    '2300' => 2.2,
                    '3000' => 2.2,
                    '2000000' => 3.2, //car enginecapacity more then 3001 cm^3
                ];
                $table = $this->carAge < 3 ? $capacityRateEurTableUpTo3yo : ($this->carAge < 7 ? $capacityRateEurTable3to7yo : $capacityRateEurTableMoreThan7yo);

                foreach (array_keys($table) as $upTo) {
                    if ((int)$this->engineCapacity > (int)$upTo) {
                        continue;
                    } else {
                        $coeff = $table[$upTo];
                        break;
                    }
                }
                if($this->carAge > 7)
                {
                    return $this->engineCapacity * $coeff * $this->rubEurRate;
                }
                else{
                    if($this->carAge < 3)
                    {
                        $percentage = 17;
                        return $carPrice * $percentage / 100;
                    }
                    else
                    {
                        $percentage = 22;
                        return max(($carPrice * $percentage / 100), $this->engineCapacity * $coeff * $this->rubEurRate);
                    }
                }
            }
        }
        return 0;
    }

    public function getAkciz($carPower)
    {
        if($this->isFizLico === true && ($this->carAge < 3 || $this->fuelType === 'gasoline'))
        {
            return 0;
        }

        //engine power (hp) => cost per 1hp
        $powerPriceTable = [
            '90' => 0,
            '150' => 49,
            '200' => 472,
            '300' => 773,
            '400' => 1317,
            '500' => 1363,
            '5000' => 1408, // more then 500 hp
        ];

        foreach(array_keys($powerPriceTable) as $upTo)
        {
            if($carPower > $upTo)
            {
                continue;
            }
            else{
                return $carPower*$powerPriceTable[$upTo];
            }
        }

    }

    public function getUtilizacSbor($isCommercial)
    {
        $bazovayaStavka = 20000;

        $coeff = $this->carAge > 3 ? 0.26 : 0.17;
        if(!$this->isFizLico)
        {
            $coeff = $this->getUtilCoeff();
        }

        return $bazovayaStavka*$coeff;
    }

    private function getUtilCoeff()
    {
        $coeff = 0;

        if(in_array($this->fuelType, ['gasoline', 'diesel', 'hybrid']))
        {
            //engine capacity (cm^3) => coeff
            $capacityCoeffTable1 = [
                '1000' => 1.42,
                '2000' => 2.21,
                '3000' => 4.22,
                '3500' => 5.73,
                '50000' => 9.08, // more then 3500 cm^3
            ];
            $capacityCoeffTable2 = [
                '1000' => 5.39,
                '2000' => 8.26,
                '3000' => 16.12,
                '3500' => 28.5,
                '50000' => 35.1, // more then 3500 cm^3
            ];
            $coeffTableFinal = $this->carAge > 3 ? $capacityCoeffTable2 : $capacityCoeffTable1;
            foreach(array_keys($coeffTableFinal) as $upTo)
            {
                if($this->engineCapacity > $upTo)
                {
                    continue;
                }
                else{
                    $coeff = $coeffTableFinal[$upTo];
                    break;
                }
            }
        }
        elseif($this->fuelType === 'electro')
        {
            $coeff = $this->carAge > 3 ? 6.1 : 1.63;
        }

        return $coeff;
    }

    public function getSborTamojOformlenie($price)
    {
        //price "up to" (thousands) => sbor(RUB) старая
        $priceSborTable = [
            '200' => 500,
            '450' => 1000,
            '1200' => 2000,
            '2500' => 5500,
            '5000' => 7500,
            '10000' => 20000,
            '30000' => 50000,
            '500000' => 100000 // more then 30 million
        ];

        foreach(array_keys($priceSborTable) as $upTo)
        {
            if($price > $upTo*1000)
            {
                continue;
            }
            else{
                return $priceSborTable[$upTo];
            }
        }
        return true;
    }
}