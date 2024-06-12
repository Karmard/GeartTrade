<?php
        if (isset($_POST["send"])) 
        {
            // INCLUDE THE EMAIL FUNCTION PAGE
            require_once 'email_functions.php';

            $email = isset($_POST["email"]) ? $_POST["email"] : "";
            $subject = $_POST["subject"];
            $message = $_POST["message"];

            // SEND THE EMAIL
            if (sendEmail('tomkarma13@gmail.com', $subject, $message)) 
            {
                echo "
                    <script>
                        alert('Email sent successfully, our agent will get back to you shortly');
                        document.location.href = 'help.html';
                    </script>
                ";
            } 
            else 
            {
                showAlert("Oops! Something went wrong. Please try again later.");
            }
        }

    function showAlert($message) 
    {
        echo "
            <script>
                alert('$message');
            </script>
        ";
        exit;
    }
