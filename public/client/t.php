<?php
include('C:\xampp\htdocs\MyLaundry\public\includes\dbcon.php');

require_once 'C:\xampp\htdocs\MyLaundry\vendor\autoload.php';
use GuzzleHttp\Client;

// Function to get conversion rate from MAD to USD
function getConversionRate($amount, $from_currency, $to_currency) {
    $client = new Client([
        'base_uri' => 'http://api.exchangeratesapi.io/v1/',
    ]);

    try {
        // Fetch EUR to MAD rate
        $response = $client->request('GET', 'latest', [
            'query' => [
                'access_key' => '9bc87331cac8edd88e1f6c3fb2b5a8a9',
                'symbols' => 'MAD',
            ]
        ]);

        if ($response->getStatusCode() != 200) {
            throw new Exception('Failed to fetch conversion rate.');
        }

        $body = $response->getBody();
        $arr_body = json_decode($body, true);
        $rateEURtoMAD = $arr_body['rates']['MAD'];

        // Fetch EUR to USD rate
        $response = $client->request('GET', 'latest', [
            'query' => [
                'access_key' => '9bc87331cac8edd88e1f6c3fb2b5a8a9',
                'symbols' => 'USD',
            ]
        ]);

        if ($response->getStatusCode() != 200) {
            throw new Exception('Failed to fetch conversion rate.');
        }

        $body = $response->getBody();
        $arr_body = json_decode($body, true);
        $rateEURtoUSD = $arr_body['rates']['USD'];

        // Calculate MAD to USD rate
        $rateMADtoUSD = $rateEURtoUSD / $rateEURtoMAD;

        return $amount * $rateMADtoUSD;
    } catch (Exception $e) {
        error_log($e->getMessage());
        echo $e->getMessage();
        return false;
    }
}

$totalMAD = 1000;
$totalUSD = getConversionRate($totalMAD, 'MAD', 'USD');
echo $totalUSD;
  


?>