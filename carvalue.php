<!DOCTYPE html>
<html>
<head>
<title>CarsXE</title>

</html>

<body>

<!-- From the website of the API: https://api.carsxe.com/docs/v2/plate-decoder#united-states -->
<!-- Get the VIN using license plate -->
<?php
 
$curl = curl_init();
 
curl_setopt_array($curl, array(
  CURLOPT_URL => 'https://api.carsxe.com/v2/platedecoder?key=18vrvvf5k_dbk8rz701_32ve489ut&plate=4WCW10&state=MA',
  CURLOPT_RETURNTRANSFER => true,
  CURLOPT_ENCODING => '',
  CURLOPT_MAXREDIRS => 10,
  CURLOPT_TIMEOUT => 0,
  CURLOPT_FOLLOWLOCATION => true,
  CURLOPT_HTTP_VERSION => CURL_HTTP_VERSION_1_1,
  CURLOPT_CUSTOMREQUEST => 'GET',
));
 
$response = curl_exec($curl);

curl_close($curl);

// Decode the JSON response
$data = json_decode($response, true);



// Check if VIN exists and print it
if (isset($data['vin'])) {
    $vin = htmlspecialchars($data['vin']);
    echo "VIN: " . $vin . "<br>";

    // Now use $vin for the second API call
    $curl = curl_init();
     
    curl_setopt_array($curl, array(
      CURLOPT_URL => 'https://api.carsxe.com/v2/marketvalue?key=18vrvvf5k_dbk8rz701_32ve489ut&vin=' . urlencode($vin),
      CURLOPT_RETURNTRANSFER => true,
      CURLOPT_ENCODING => '',
      CURLOPT_MAXREDIRS => 10,
      CURLOPT_TIMEOUT => 0,
      CURLOPT_FOLLOWLOCATION => true,
      CURLOPT_HTTP_VERSION => CURL_HTTP_VERSION_1_1,
      CURLOPT_CUSTOMREQUEST => 'GET',
    ));
     
    $marketValueResponse = curl_exec($curl);
    curl_close($curl);

    // DECODE it
    $marketValueData = json_decode($marketValueResponse, true);

    // Then access the value
    $tradeInClean = htmlspecialchars($marketValueData['trade_in_clean']['adjusted_trade_in_clean']);

    echo $tradeInClean;

} else {
    echo "VIN not found in the response.";
}

?>

</body>
</html>