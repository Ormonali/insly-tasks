<?php
include 'calculator.php';
header("Content-Type: application/json; charset=UTF-8");
ini_set('display_errors', 1);
ini_set('display_startup_errors', 1);
error_reporting(E_ALL);
if($_SERVER['REQUEST_METHOD'] == "POST"){
    // takes raw data from the request 
    // Converts it into a PHP object 
    $data = json_decode( file_get_contents( 'php://input' ), true );
    $value = isset($data['value']) ? $data['value'] : 0;
    $tax_percentage = isset($data['tax']) ? $data['tax'] : 0;
    $installments = isset($data['installments']) ? $data['installments'] : 0;

    $payment = new Calculator($value, $tax_percentage, $installments);
    $basePrice = $payment->base_price();
    $commission = $payment->price_w_commission($basePrice);
    $tax = $payment->tax($basePrice);
    $totalCost = number_format((float) $basePrice + $commission + $tax, 2, '.', '');

    $basePriceArray = $payment->calc_installments($basePrice); 
    $commissionArray = $payment->calc_installments($commission); 
    $taxArray = $payment->calc_installments($tax); 
    $totalCostArray = $payment->calc_total($basePriceArray, $commissionArray, $taxArray); 
    $basePercent = $payment->get_base_percent();
    $commissionPercent = $payment->get_commission_percent();
    $json_resp = json_encode([
        "basePercent" => $basePercent,
        "commissionPercent" => $commissionPercent,
        "taxPercent" => $tax_percentage,
        "basePriceArray" => $basePriceArray,
        "commissionArray" => $commissionArray,
        "taxArray" => $taxArray,
        "totalCostArray" => $totalCostArray,
    ]);

    echo $json_resp;
}


?>