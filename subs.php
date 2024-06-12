<?php
session_start();
include_once "connection.php";
require_once "email_functions.php";

define('CONSUMER_KEY', 'pgeWav95xhuthNmR4RiXD9HC9CFdW3lX6HpiAUuWaQQvjr7T');
define('CONSUMER_SECRET', 'EqeYAAZQ1lj8V0psSeHnqdmAG3gCaxvvpiKoArB0a6BqUQnUMo1DqlebqF5SJVjh');
define('SHORTCODE', 'N/A');
define('PASSKEY', '123321@@Tb');

function getAccessToken() 
{
    $url = 'https://sandbox.safaricom.co.ke/oauth/v1/generate?grant_type=client_credentials';

    $credentials = base64_encode(CONSUMER_KEY . ':' . CONSUMER_SECRET);
    $headers = array(
        'Authorization: Basic ' . $credentials,
        'Content-Type: application/json'
    );

    $curl = curl_init();
    curl_setopt($curl, CURLOPT_URL, $url);
    curl_setopt($curl, CURLOPT_HTTPHEADER, $headers);
    curl_setopt($curl, CURLOPT_HEADER, false);
    curl_setopt($curl, CURLOPT_RETURNTRANSFER, true);
    curl_setopt($curl, CURLOPT_SSL_VERIFYPEER, false);

    $response = curl_exec($curl);
    curl_close($curl);

    $data = json_decode($response, true);
    return $data['access_token'];
}

function lipaNaMpesa($amount, $phone_number) 
{
    $access_token = getAccessToken();
    $url = 'https://sandbox.safaricom.co.ke/mpesa/stkpush/v1/processrequest';
    $timestamp = date('YmdHis');

    $password = base64_encode(SHORTCODE . PASSKEY . $timestamp);

    $request_data = array(
        'BusinessShortCode' => SHORTCODE,
        'Password' => $password,
        'Timestamp' => $timestamp,
        'TransactionType' => 'CustomerPayBillOnline',
        'Amount' => $amount,
        'PartyA' => $phone_number,
        'PartyB' => SHORTCODE,
        'PhoneNumber' => $phone_number,
        'CallBackURL' => 'https://geartradehub.com/mpesa_callback.php', 
        'AccountReference' => 'Subscription',
        'TransactionDesc' => 'Payment for subscription'
    );

    $curl = curl_init();
    curl_setopt($curl, CURLOPT_URL, $url);
    curl_setopt($curl, CURLOPT_HTTPHEADER, array('Content-Type: application/json', 'Authorization:Bearer ' . $access_token));
    curl_setopt($curl, CURLOPT_RETURNTRANSFER, true);
    curl_setopt($curl, CURLOPT_POST, true);
    curl_setopt($curl, CURLOPT_POSTFIELDS, json_encode($request_data));

    $response = curl_exec($curl);
    curl_close($curl);

    return json_decode($response, true);
}

if (!isset($_SESSION['UserID'])) 
{
    header("Location: login.php");
    exit;
}

$adminUserID = $_SESSION['UserID'];

$query_subscription = "SELECT * FROM subscription WHERE UserID = ? AND end_date >= CURDATE()";
$stmt_subscription = $connection->prepare($query_subscription);
$stmt_subscription->bind_param("s", $adminUserID);
$stmt_subscription->execute();
$result_subscription = $stmt_subscription->get_result();
$userSubscribed = $result_subscription->num_rows > 0;
$subscription = $userSubscribed ? $result_subscription->fetch_assoc() : null;

$plan = $userSubscribed ? $subscription['plan'] : "";

if ($_SERVER["REQUEST_METHOD"] == "POST") 
{
    if (isset($_POST['plan'])) 
    {
        $selected_plan = $_POST['plan'];
        $selected_payment_method = $_POST['payment_method'];
        $phone_number = $_POST['phone_number']; 

        if ($selected_plan === 'plus') 
        {
            $plan = "Plus Plan";
            $price = 1000;
        }
         elseif ($selected_plan === 'pro') 
        {
            $plan = "Pro Plan";
            $price = 1800;
        } 
        else 
        {
            echo "Invalid plan selected.";
            exit;
        }

        if ($selected_payment_method === 'mpesa') 
        {
            $mpesa_response = lipaNaMpesa($price, $phone_number);
            if (isset($mpesa_response['ResponseCode']) && $mpesa_response['ResponseCode'] == "0") 
            {
                echo '<script>alert("Payment request sent. Please complete the payment on your phone.");</script>';
                $transaction_id = $mpesa_response['CheckoutRequestID'];
                $start_date = date('Y-m-d');
                $end_date = date('Y-m-d', strtotime('+30 days'));

                $sql = "INSERT INTO subscription (UserID, plan, start_date, end_date, price, transaction_id) VALUES (?, ?, ?, ?, ?, ?)";
                $stmt = $connection->prepare($sql);
                $stmt->bind_param("ssssss", $adminUserID, $selected_plan, $start_date, $end_date, $price, $transaction_id);

                if ($stmt->execute()) 
                {
                    echo '<script>window.location.href = "account.php";</script>';
                    exit;
                } 
                else 
                {
                    echo "Error adding subscription: " . $stmt->error;
                }
            } 
            else 
            {
                echo '<script>alert("Error initiating payment: ' . $mpesa_response['errorMessage'] . '");</script>';
            }
        } 
        else 
        {
        }
    }

    if (isset($_POST['cancel_subscription'])) 
    {
        $sql = "UPDATE subscription SET end_date = CURDATE() WHERE UserID = ? AND end_date >= CURDATE()";
        $stmt = $connection->prepare($sql);
        $stmt->bind_param("s", $adminUserID);

        if ($stmt->execute()) 
        {
            echo '<script>alert("Subscription cancelled successfully.");</script>';
            echo '<script>window.location.href = "account.php";</script>';
            exit;
        } 
        else 
        {
            echo "Error cancelling subscription: " . $stmt->error;
        }
    }
}

$connection->close();
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Subscription Plans</title>
    <link rel="stylesheet" href="STYLING/subscription.css">
</head>
<body>
    <div class="container">

        <?php if ($userSubscribed) : ?>
            <h1>You are already subscribed to <?php echo $plan; ?></h1>
        <?php else: ?>
            <h1>Choose a Subscription Plan</h1>
        <?php endif; ?>
        <div class="plan-container">
            <div class="plan">
                <h2>Plus Plan (Ksh 1000/month)</h2>
                <ul>
                    <li>Users can list a maximum of 4 cars per month.</li>
                    <li>One of the listed cars can be featured on the homepage for increased visibility.</li>
                    <li>Access to priority customer support for quicker assistance.</li>
                    <li>Exclusive discounts on premium services such as car detailing or inspections.</li>
                    <li>Receive a monthly newsletter with tips and insights on car maintenance and buying.</li>
                    <li>Participate in members-only forums to discuss car-related topics.</li>
                </ul>
                <form id="plus_plan_form" action="<?php echo htmlspecialchars($_SERVER["PHP_SELF"]); ?>" method="post">
                    <input type="hidden" name="plan" value="plus">
                    <input type="hidden" name="payment_method" value="mpesa">
                    <input type="text" name="phone_number" placeholder="Enter your M-Pesa phone number" required>
                    <button type="submit">Select Plus Plan</button>
                </form>
            </div>
            
            <div class="plan2">
                <h2>Pro Plan (Ksh 1800/month)</h2>
                <ul>
                    <li>Users can list an unlimited number of cars per month.</li>
                    <li>Two of the listed cars can be featured on the homepage for increased visibility.</li>
                    <li>Access to priority customer support for quicker assistance.</li>
                    <li>Enhanced discounts on premium services such as car detailing or inspections.</li>
                    <li>Receive a monthly newsletter with advanced tips and insights on car maintenance and buying.</li>
                    <li>Participate in members-only forums to discuss car-related topics.</li>
                    <li>Get early access to new features and updates before they are released to the general public.</li>
                </ul>
                <form id="pro_plan_form" action="<?php echo htmlspecialchars($_SERVER["PHP_SELF"]); ?>" method="post">
                    <input type="hidden" name="plan" value="pro">
                    <input type="hidden" name="payment_method" value="mpesa">
                    <input type="text" name="phone_number" placeholder="Enter your M-Pesa phone number" required>
                    <button type="submit">Select Pro Plan</button>
                </form>
            </div>
        </div>

        <p class="caution-text">Please read carefully the plan privileges before selecting. Canceling of subscription will not be refunded.</p>


    </div>
    <section id="subscribeSection">
        <button id="subscribeButton" onclick="window.location.href = 'account.php'">Back to Account</button>
        <?php if ($userSubscribed) : ?>
            <form id="cancel_subscription_form" action="<?php echo htmlspecialchars($_SERVER["PHP_SELF"]); ?>" method="post" style="display: inline;">
                <input type="hidden" name="cancel_subscription" value="1">
                <button type="submit" id="cancelSubscriptionButton">Cancel Subscription</button>
            </form>
        <?php endif; ?>
        <p id="subscriptionStatus"></p>
    </section>    

</body>
</html>
