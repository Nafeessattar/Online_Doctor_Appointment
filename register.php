<?php
require('config.php');

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $username = $_POST['username'];
    $password = password_hash($_POST['password'], PASSWORD_DEFAULT);
    $full_name = $_POST['full_name'];
    $user_type = $_POST['user_type'];


    $phone_number = '';
    $city = '';
    $booking_info = '';
    $specialization = ''; 

    if ($user_type == 'doctors') {

        $phone_number = $_POST['phone_number'];
        $city = $_POST['city'];
        $booking_info = $_POST['booking_info'];
        $specialization = $_POST['specialization']; 
    }

    if ($user_type == 'doctors') {
        $sql = "INSERT INTO doctors (username, password, full_name, phone_number, city, booking_info, specialization) 
                VALUES ('$username', '$password', '$full_name', '$phone_number', '$city', '$booking_info', '$specialization')";
    } else {
        $sql = "INSERT INTO patients (username, password, full_name) VALUES ('$username', '$password', '$full_name')";
    }

    if ($conn->query($sql) === TRUE) {
        header("Location: login.php");
    } else {
        echo "Error: " . $sql . "<br>" . $conn->error;
    }
}
?>

<!DOCTYPE html>
<html>
<head>
    <title>Registration</title>
    <style>
        body {
            font-family: Arial, sans-serif;
            background-color: #f4f4f4;
            text-align: center;
        }

        h2 {
            color: #333;
        }

        form {
            background-color: #fff;
            max-width: 400px;
            margin: 0 auto;
            padding: 20px;
            border-radius: 5px;
            box-shadow: 0 0 10px rgba(0, 0, 0, 0.2);
        }

        label {
            display: block;
            margin-bottom: 8px;
        }

        input[type="text"],
        input[type="password"],
        select {
            width: 100%;
            padding: 10px;
            margin-bottom: 20px;
            border: 1px solid #ccc;
            border-radius: 5px;
        }

        input[type="submit"] {
            background-color: #007BFF;
            color: #fff;
            padding: 10px 20px;
            border: none;
            border-radius: 5px;
            cursor: pointer;
        }

        input[type="submit"]:hover {
            background-color: #0056b3;
        }

        #doctor_fields {
            display: none;
        }
    </style>
</head>
<body>
    <h2>Registration</h2>
    <form method="POST" action="">
        <label>Username:</label>
        <input type="text" name="username" required>

        <label>Password:</label>
        <input type="password" name="password" required>

        <label>Full Name:</label>
        <input type="text" name="full_name" required>

        <label>User Type:</label>
        <select name="user_type" id="user_type" required>
            <option value="doctors">Doctor</option>
            <option value="patients">Patient</option>
        </select>

        <div id="doctor_fields">
            <label>Phone Number:</label>
            <input type="text" name="phone_number">

            <label>City:</label>
            <input type="text" name="city">

            <label>Booking Info:</label>
            <input type="time" name="booking_info">

            <label>Specialization:</label> 
            <input type="text" name="specialization">
        </div>
        <input type="submit" value="Register">
    </form>
    <script>
        document.getElementById('user_type').addEventListener('change', function() {
            var doctorFields = document.getElementById('doctor_fields');
            if (this.value === 'doctors') {
                doctorFields.style.display = 'block';
            } else {
                doctorFields.style.display = 'none';
            }
        });
    </script>
</body>
</html>

