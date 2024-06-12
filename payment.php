<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Payment Method</title>
    <link rel="stylesheet" href="STYLING/payment.css">
    <style>
        .container 
        {
            max-width: 400px;
            margin: 0 auto;
            padding: 20px;
            border: 1px solid #ccc;
            border-radius: 5px;
            background-color: #f9f9f9;
        }

        h1 
        {
            text-align: center;
            margin-bottom: 20px;
        }

        form 
        {
            display: flex;
            flex-direction: column;
        }

        label 
        {
            margin-bottom: 8px;
        }

        select,
        input[type="number"] 
        {
            padding: 10px;
            margin-bottom: 15px;
            border: 1px solid #ccc;
            border-radius: 5px;
            box-sizing: border-box;
            width: 100%;
        }

        button[type="submit"] 
        {
            padding: 10px;
            border: none;
            border-radius: 5px;
            background-color: #007bff;
            color: #fff;
            font-size: 16px;
            cursor: pointer;
            width: 100%;
        }

        button[type="submit"]:hover 
        {
            background-color: #0056b3;
        }

    </style>
</head>
<body>
    <div class="container">
        <h1>Choose Payment Method and Enter Amount</h1>
        <form action="process_payment.php" method="post" id="paymentForm">
            <label for="payment_method">Payment Method:</label>
            <select id="payment_method" name="payment_method">
                <option value="paypal">PayPal</option>
                <option value="card">Credit/Debit Card</option>
            </select>
            <br>
            <label for="amount">Amount:</label>
            <input type="number" id="amount" name="amount" required>
            <br>
            <input type="hidden" name="plan" id="plan" value="<?php echo isset($_POST['plan']) ? htmlspecialchars($_POST['plan']) : ''; ?>">
            <button type="submit">Proceed to Payment</button>
        </form>
    </div>

    <script>
        document.getElementById('payment_method').addEventListener('change', function() 
        {
            var selectedPlan = document.getElementById('plan').value;
            var amountInput = document.getElementById('amount');
            if (selectedPlan === 'plus') 
            {
                amountInput.value = '1000';
            } 
                else if (selectedPlan === 'pro') 
            {
                amountInput.value = '1800';
            }
        });
    </script>
</body>
</html>
