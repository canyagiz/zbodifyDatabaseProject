<?php
include "connect.php";
include "session_check.php";

$errors = []; // Array to store errors
$payDate = date("Y-m-d");

if (isset($_POST['pay_button'])) {
    $payment_name = $_POST['payment_name'];
    $CC_fname = $_POST['CC_fname'];
    $CC_mname = $_POST['CC_mname'];
    $CC_lname = $_POST['CC_lname'];
    $card_number = $_POST['card_number'];
    $CC_date = $_POST['CC_date'];
    $CVV = $_POST['CVV'];
    $user_id = $_SESSION['user_id'];

    // Check if PAYuserId already exists
    $check_query = "SELECT * FROM PAYING WHERE PAYuserId = $user_id";
    $result = $conn->query($check_query);
    $row = $result->fetch_assoc();

    // Check the lengths of the fields and add errors to the errors array
    if (strlen($card_number) !== 16) {
        $errors[] = "Card number must be 16 digits long.";
    }

    if (strlen($CC_date) !== 5) {

        $errors[] = "Expiration date must be in MM/YY format.";
    }

    if (12 < (int) (substr($CC_date, 0, 2)) || (int) (substr($CC_date, 0, 2)) < 0 || 48 < (int) (substr($CC_date, 3)) || (int) (substr($CC_date, 3)) < 24) {
        $errors[] = "Enter valid date.";
    }

    if (strlen($CVV) != 3) {
        $errors[] = "CVV must be 3 characters long.";
    }

    if ((int) ($CVV) < 0) {
        $errors[] = "CVV must be positive number.";
    }

    if ($result->num_rows == 1 && $row['PAYmtype'] == 'Premium') {
        $errors[] = "You already premium member.";

        
    } elseif ($row['PAYmtype'] == 'Standard') {
        $query_update_paym = "UPDATE PAYMENT

                               SET PAYM_name = '$payment_name',

                               PAYM_CC_fname = '$CC_fname',

                               PAYM_CC_mname = '$CC_mname',

                               PAYM_CC_lname = '$CC_lname',

                               PAYM_CC_number = '$card_number',

                               PAYM_CC_date = '$CC_date',

                               PAYM_CC_CVV = '$CVV'

                               WHERE PAYM_UserId = '$user_id'";

         $query_update_paying = "UPDATE PAYING
         SET PAYmtype = 'Premium',
             PAYisPaid = '1',
             PAYdate = '$payDate'
         WHERE PAYuserId = '$user_id';";


        if ($conn->query($query_update_paym) === true && $conn->query($query_update_paying) === true) {
            header("Location: main.php");
            exit();
        } else {
            echo "Error: " . $conn->error;
        }

    } else {
        // If there are no errors, insert the payment information into the database
        $insert_payment_query = "INSERT INTO PAYMENT (PAYM_UserId, PAYM_name, PAYM_CC_fname, PAYM_CC_mname, PAYM_CC_lname, PAYM_CC_number, PAYM_CC_date, PAYM_CC_CVV)
        VALUES ('$_SESSION[user_id]', '$payment_name','$CC_fname', '$CC_mname', '$CC_lname', '$card_number', '$CC_date', '$CVV')";

        $insert_paying_query = "INSERT INTO PAYING (PAYUserId,PAYmtype, PAYisPaid, PAYdate)
        VALUES ('$_SESSION[user_id]', 'Premium', '1', '$payDate')";

        if ($conn->query($insert_payment_query) === true && $conn->query($insert_paying_query) === true) {
            header("Location: main.php");
            exit();
        } else {
            echo "Error: " . $conn->error;
        }
    }

    // If there are errors, display them
    if (!empty($errors)) {
        foreach ($errors as $error) {
            echo "<p>$error</p>";
        }
    }
}

?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="membership-type.css">
    <title>Payment Page</title>
</head>
<body>

    <input type="radio" name="optionScreen" id="SignIn" hidden checked>


        <section>
            <div id="logo">
            </div>

        <nav>
            <label for="SignIn">Payment</label>

        </nav>
        <form action="membership-type2.php" id="SignInFormData" method="post">
            <input type="text" name="payment_name" id="payment_name" placeholder="Payment Name">
            <input type="text" name="CC_fname" id="CC_fname" placeholder="First Name">
            <input type="text" name="CC_mname" id="CC_mname" placeholder="Mid name (if has)">
            <input type="text" name="CC_lname" id="CC_lname" placeholder="Surname">
            <input type="text" name="card_number" id="card-number" placeholder="Card Number">
            <input type="text" name="CC_date" id="CC_date" placeholder="Expire Date">
            <input type="text" name="CVV" id="CVV" placeholder="CVV">
            <p>Payment Fee: 10$ </p>
            <button type="submit" name="pay_button" title="Pay">Pay</button>


        </form>

    </section>
    <script
    src="https://kit.fontawesome.com/23cecef777.js"
    crossorigin="anonymous"
  ></script>
</body>
</html>
