<?php

class Calculator {
    private $estimatedValue = 0;
    private $percentageTax = 0;
    private $installments = 0;
    
    public $basePercent = 11.00;
    public $specBasePercent = 13.00;
    public $commission = 17.00; 
   
    function __construct(float $estimatedValue, float $percentageTax, int $numberOfInstallments) {
        $this->estimatedValue = $estimatedValue;
        $this->percentageTax = $percentageTax; 
        $this->installments = $numberOfInstallments; 
    }

    public function get_estimated_value() : float {
        return $this->$estimatedValue;
    }

    public function get_base_percent() : float {
        $percent = $this->basePercent;
        if(date('D') === 'Fri' && date('H') >= 15 && date('H') < 20 ) {
            $percent = $this->specBasePercent;
        }
        return $percent;
    }
    
    public function get_percentage_tax() : float {
        return $this->percentageTax;
    }

    public function get_commission_percent() : float {
        return $this->commission;
    } 

    public function get_number_of_installments() : float {
        return $this->installments;
    }

    
    public function base_price() {
        $percent = $this->get_base_percent();
        $price = $this->value_f_percent($this->estimatedValue, $percent);
        return $price;
    }

    public function price_w_commission($base_price) {
        $price = $this->value_f_percent($base_price, $this->commission);
        return $price;
    }

    public function tax($base_price) {
        $price = $this->value_f_percent($base_price, $this->percentageTax);
        return $price;
    }

    public function value_f_percent($price, $percent) {
        return number_format((float) $price * ($percent / 100), 2, '.', '');
    }

    public function calc_installments($price) {
        $installments = [ $price ];
        $installmentPrice = round( $price / $this->installments, 2);
        $dividedEqually = false;
        $modulo = ($installmentPrice * $this->installments) - $price;
        if($price !=0 && $installmentPrice!=0 && $modulo){
            $dividedEqually = true;
        }
        for ($i=0; $i < $this->installments; $i++) {
            if($dividedEqually && $i == $this->installments - 1){
                $installmentPrice =  $installmentPrice - $modulo;
            }
            array_push($installments, number_format((float) $installmentPrice, 2, '.', ''));
        }
        return $installments;
    }

    public function calc_total($base_price, $commission, $tax){
        $total_arr = [];
        for ($i=0; $i < count($base_price); $i++) { 
            $value = number_format((float) $base_price[$i] + $commission[$i] + $tax[$i], 2, '.', '');
            array_push($total_arr, $value);
        }
        return $total_arr;
    }
}

?>