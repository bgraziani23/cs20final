<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8" />
  <meta name="viewport" content="width=device-width, initial-scale=1.0" />
  <meta name="keywords" content="Cars, Used Cars, Cheap, Dealership, Selling">
  <title>Car Value</title>
  <script src="https://code.jquery.com/jquery-3.7.1.min.js" crossorigin="anonymous"></script>
  <link rel="stylesheet" href="style.css">
  <link href="https://fonts.googleapis.com/css2?family=Bebas+Neue&family=Fira+Sans:wght@400;700&display=swap" rel="stylesheet">
  <style>
    .container {
      font-family: "Bebas Neue", sans-serif;
      letter-spacing: 2px;
      width: 50%;
      margin: 50px auto;
      padding: 20px;
      background: #fff;
      border: 1px solid #ccc;
      border-radius: 10px;
      box-shadow: 0 0 10px rgba(0,0,0,0.1);
    }
    label {
      display: block;
      margin: 15px 0 5px;
      text-align: left;
    }
    select, input[type="text"] {
      width: 100%;
      padding: 8px;
      box-sizing: border-box;
    }
    select, input[type="dropdown"] {
      width: 10%;
      padding: 8px;
      box-sizing: border-box;
    }
    .submitBtn {
      font-family: "Bebas Neue", sans-serif;
      border-width: 0px;
      letter-spacing: 1px;
      margin-top: 10px;
      display: block;
      padding: 10px 20px;
      font-size: 15px;
      color: white;
      background: #007BFF;
      border-radius: 5px;
      transition: background 0.2s;
    }
    .submitBtn:hover {
      background: #0056b3;
    }
    .error {
      color: red;
      font-size: 16px;
    }
    .resultContainer {
      display: none;
      text-align: center;
      align-items: center;
      font-size: 36px;
      margin-top: 20px;
    }
    .resultContainer div {
      margin: 10px 0;
      display: none;
      font-size: 30px;
    }
    .searchingText {
      font-size: 28px;
      display: none;
      margin-bottom: 20px;
    }
    .footer {
      position: absolute;
      top: 95vh;
    }
    @media (max-width: 1050px) {
      .resultContainer {
        font-size: 25px;
      }
      .resultContainer div {
        font-size: 25px;
      }
      .container {
        width: 75%;
      }
    }
  </style>
</head>
<body>
    <a href="home.html" class="logo-container">
        <img src="images/logo.png">
    </a>

    <script src="navBar.js"></script>

    <!-- Normal Nav Bar -->
    <div class="nav-container">
        <br />
        <a href="home.html" class="nav-button">Home</a>
        <a href="shop.php" class="nav-button">Shop</a>
        <a href="tinder.html" class="nav-button">Tinder</a>
        <a href="carvalue.php" class="nav-button">Car Value Calculator</a>
        <a href="about.html" class="nav-button">About Us</a>
        <a href="help.html" class="nav-button">Help</a>
        <a href="reviews.html" class="nav-button">Reviews</a>
        <a href="contact.html" class="nav-button">Contact Us</a>
        <br /><br />
    </div>

    <!-- Hamburger Nav Bar -->
    <div class="nav-hamburger-container">
        <br /><a>Not showing</a><br />
    </div>

    <div class="hamburger-container">
        <button onclick="toggleMenu()">&nbsp;&equiv;&nbsp;</button>
    </div>

    <span class="hamburger-button-container-closed">
        <br /><br /><br /><br />
        <a href="home.html" class="nav-button-hamburger-closed">Home</a>
        <a href="shop.php" class="nav-button-hamburger-closed">Shop</a>
        <a href="tinder.html" class="nav-button-hamburger-closed">Tinder</a>
        <a href="carvalue.php" class="nav-button-hamburger-closed">Car Value Calculator</a>
        <a href="about.html" class="nav-button-hamburger-closed">About Us</a>
        <a href="help.html" class="nav-button-hamburger-closed">Help</a>
        <a href="reviews.html" class="nav-button-hamburger-closed">Reviews</a>
        <a href="contact.html" class="nav-button-hamburger-closed">Contact Us</a>
    </span>

  <!-- License Plate Form -->
  <div class="container">
    <form method="GET">
      <label for="plate">License Plate:</label>
      <input type="text" id="plate" name="plate" value="<?php echo isset($_GET['plate']) ? htmlspecialchars($_GET['plate']) : 'ABC123'; ?>">

      <label for="state">State:</label>
      <select id="state" name="state">
        <?php
        $states = ["Select", "AL","AK","AZ","AR","CA","CO","CT","DE","FL","GA",
                  "HI","ID","IL","IN","IA","KS","KY","LA","ME","MD",
                  "MA","MI","MN","MS","MO","MT","NE","NV","NH","NJ",
                  "NM","NY","NC","ND","OH","OK","OR","PA","RI","SC",
                  "SD","TN","TX","UT","VT","VA","WA","WV","WI","WY"];
        $selectedState = isset($_GET['state']) ? $_GET['state'] : 'Select';
        foreach ($states as $state) {
          $selected = ($state == $selectedState) ? 'selected' : '';
          echo "<option value=\"$state\" $selected>$state</option>";
        }
        ?>
      </select>

      <button class="submitBtn" type="submit">Submit</button>
    </form>

<?php
if (isset($_GET['plate']) && isset($_GET['state'])) {
    $plate = urlencode($_GET['plate']);
    $state = urlencode($_GET['state']);
    $apiKey = '18vrvvf5k_dbk8rz701_32ve489ut';

    // Get VIN using license plate
    $curl = curl_init();
    curl_setopt_array($curl, array(
      CURLOPT_URL => "https://api.carsxe.com/v2/platedecoder?key=$apiKey&plate=$plate&state=$state",
      CURLOPT_RETURNTRANSFER => true,
    ));
    $response = curl_exec($curl);
    curl_close($curl);
    $data = json_decode($response, true);

    if (isset($data['vin'])) {
        $vin = htmlspecialchars($data['vin']);

        // Get market value
        $curl = curl_init();
        curl_setopt_array($curl, array(
          CURLOPT_URL => "https://api.carsxe.com/v2/marketvalue?key=$apiKey&vin=$vin",
          CURLOPT_RETURNTRANSFER => true,
        ));
        $marketValueResponse = curl_exec($curl);
        curl_close($curl);
        $marketValueData = json_decode($marketValueResponse, true);

        $tradeInClean = null;
        if (isset($marketValueData['trade_in_clean']['adjusted_trade_in_clean'])) {
            $tradeInClean = htmlspecialchars($marketValueData['trade_in_clean']['adjusted_trade_in_clean']);
        }

        // Get specs
        $curl = curl_init();
        curl_setopt_array($curl, array(
          CURLOPT_URL => "https://api.carsxe.com/v2/specs?key=$apiKey&vin=$vin",
          CURLOPT_RETURNTRANSFER => true,
        ));
        $makeModelResponse = curl_exec($curl);
        curl_close($curl);
        $specsData = json_decode($makeModelResponse, true);

        if (isset($specsData['attributes'])) {
            $year = htmlspecialchars($specsData['attributes']['year']);
            $make = htmlspecialchars($specsData['attributes']['make']);
            $model = htmlspecialchars($specsData['attributes']['model']);

            echo '<div class="resultContainer">';
            echo '<div class="searchingText">Searching...</div>';
            echo '<div id="year">Year: ' . $year . '</div>';
            echo '<div id="make">Make: ' . $make . '</div>';
            echo '<div id="model">Model: ' . $model . '</div>';
            if ($tradeInClean !== null) {
                echo '<div id="value">Estimated Value: $' . $tradeInClean . '</div>';
            } else {
                echo '<div id="value">Market value not found.</div>';
            }
            echo '</div>';

            echo <<<SCRIPT
            <script>
            $(document).ready(function() {
              $(".resultContainer").show();
              $(".searchingText").fadeIn(800, function() {
                setTimeout(function() {
                  $("#year").fadeIn(1000, function() {
                    setTimeout(function() {
                      $("#make").fadeIn(1000, function() {
                        setTimeout(function() {
                          $("#model").fadeIn(1000, function() {
                            setTimeout(function() {
                              $("#value").fadeIn(1000, function() {
                                // Hide the "Searching..." text after all results have been displayed
                                $(".searchingText").hide();
                              });
                            }, 1000);
                          });
                        }, 1000);
                      });
                    }, 1000);
                  });
                }, 1000);
              });
            });
            </script>
            SCRIPT;
        } else {
            echo "Vehicle attributes not found.";
        }

    } else {
        echo '<br />';
        echo '<div style="text-align: center; font-size: 24px;">';
        echo 'License Plate not Recognized.';
        echo '<br />';
        echo 'Please double check the plate and state before resubmitting.';
        echo '</div>';
    }
}
?>
  </div>

</body>
</html>