<?php
session_start();
include_once "connection.php";
require_once "email_functions.php";

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

        $start_date = date('Y-m-d'); 
        $end_date = date('Y-m-d', strtotime('+30 days'));

        $sql = "INSERT INTO subscription (UserID, plan, start_date, end_date, price) VALUES (?, ?, ?, ?, ?)";
        $stmt = $connection->prepare($sql);
        $stmt->bind_param("sssss", $adminUserID, $selected_plan, $start_date, $end_date, $price);

        if ($stmt->execute()) 
        {
            $query_username = "SELECT username, email FROM users WHERE UserID = ?";
            $stmt_username = $connection->prepare($query_username);
            $stmt_username->bind_param("s", $adminUserID);
            $stmt_username->execute();
            $result_username = $stmt_username->get_result();
            $row_username = $result_username->fetch_assoc();
            $username = $row_username['username'];
            $user_email = $row_username['email'];

            $email_subject = "Subscription Confirmation";
            $email_message = "Dear $username,<br><br>";
            $email_message .= "Thank you for subscribing to Gear Trade Hub. We hope you enjoy our services.<br>";
            $email_message .= "Your subscription ends on $end_date.<br><br>";
            $email_message .= "Regards,<br>";
            $email_message .= "GTH Support";

            if (sendEmail($user_email, $email_subject, $email_message)) 
                {
                    echo '<script>alert("Subscription added successfully! Check your email for confirmation.");</script>';
                    echo '<script>window.location.href = "account.php";</script>';
                    exit;
                } 
            else 
                {
                    echo "Error sending email.";
                }
        } 
        else 
            {
                echo "Error adding subscription: " . $stmt->error;
            }

        $stmt->close();
        $stmt_username->close();
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

        $stmt->close();
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
                    <select id="payment_method_plus" name="payment_method">
                        <option value="">Select Payment Method</option>
                        <option value="paypal">PayPal</option>
                        <option value="card">Credit/Debit Card</option>
                        <option value="astropay">AstroPay</option>
                    </select>
                    <button type="button" onclick="validateAndSubmit('plus')">Select Plus Plan</button>
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
                    <select id="payment_method_pro" name="payment_method">
                        <option value="">Select Payment Method</option>
                        <option value="paypal">PayPal</option>
                        <option value="card">Credit/Debit Card</option>
                        <option value="astropay">AstroPay</option>
                    </select>
                    <button type="button" onclick="validateAndSubmit('pro')">Select Pro Plan</button>
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

    <script>
        function validateAndSubmit(planType) 
        {
            var paymentMethodSelect = document.getElementById('payment_method_' + planType);
            var selectedPaymentMethod = paymentMethodSelect.value;

            if (selectedPaymentMethod === '') 
                {
                    alert('Please select a payment method.');
                } 
            else 
                {
                    if (planType === 'plus') 
                        {
                            document.getElementById('plus_plan_form').submit();
                        } 
                    else if (planType === 'pro') 
                        {
                            document.getElementById('pro_plan_form').submit();
                        }
                }
        }
    </script>
</body>
</html>
