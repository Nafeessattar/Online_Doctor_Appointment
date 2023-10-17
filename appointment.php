<!DOCTYPE html>
<html>
<head>
    <title>Appointment Form</title>
    <link rel="stylesheet" href="//code.jquery.com/ui/1.12.1/themes/base/jquery-ui.css">
    <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
    <script src="https://code.jquery.com/ui/1.12.1/jquery-ui.js"></script>
    <style>
        body {
            font-family: Arial, sans-serif;
            background-color: #f4f4f4;
            text-align: center;
            margin: 0;
            padding: 0;
        }

        h2 {
            color: #333;
            margin-top: 20px;
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
    </style>
</head>
<body>
    <h2>Appointment Booking</h2>
    <form method="POST" action="appointment.php">
        <label for="appointment_date">Appointment Date:</label>
        <input type="text" id="appointment_date" name="appointment_date" required><br><br>

        <label for="appointment_time">Appointment Time:</label>
        <select id="appointment_time" name="appointment_time">
            <!-- JavaScript will populate the options here -->
        </select>
        
        <script>
            const timeSelect = document.getElementById("appointment_time");

            for (let hour = 13; hour <= 17; hour++) {
                for (let minute = 0; minute < 60; minute += 15) {
                    const option = document.createElement("option");
                    const timeString = `${hour.toString().padStart(2, "0")}:${minute.toString().padStart(2, "0")}`;
                    option.value = timeString;
                    option.text = `${hour}:${minute === 0 ? "00" : minute}`;
                    timeSelect.appendChild(option);
                }
            }
        </script>
        
        <input type="submit" value="Book Appointment">
    </form>

    <script>
        $(function () {
            $("#appointment_date").datepicker({
                defaultDate: "+1w",
                changeMonth: true,
                numberOfMonths: 1,
                beforeShowDay: $.datepicker.noWeekends
            });
        });
    </script>
</body>
</html>






<?php
include('config.php');

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $appointment_date = $_POST['appointment_date'];
    $appointment_time = $_POST['appointment_time'];

    // Convert the date to a format suitable for the database, assuming the date format is 'Y-m-d'
    $formatted_date = date('Y-m-d', strtotime($appointment_date));

    $sql = "INSERT INTO appointments (appointment_date, appointment_time)
            VALUES ('$formatted_date', '$appointment_time')";

    // Execute the SQL query and handle any errors
    if ($conn->query($sql) === TRUE) {
        echo "Appointment booked successfully.";
    } else {
        echo "Error: " . $sql . "<br>" . $conn->error;
    }

    $conn->close();
}
include('config.php');

if ($_SERVER['REQUEST_METHOD'] == 'GET' && isset($_GET['doctor_name'])) {
    $doctor_name = $_GET['doctor_name'];

    // Query the database to fetch the doctor's details based on the name
    $sql = "SELECT * FROM doctors WHERE full_name = '$doctor_name'";
    $result = $conn->query($sql);

    if ($result->num_rows > 0) {
        while ($row = $result->fetch_assoc()) {
            echo "<h2>Available Time</h2>";
            echo "<p>Booking Info: {$row['booking_info']}</p>";
        }
    } else {
        echo "<p>No doctor details found for $doctor_name.</p>";
    }
}

$conn->close();

?>

