<!DOCTYPE html>
<html>
<head>
    <title>Welcome</title>
    <style>
        body {
            font-family: Arial, sans-serif;
            background-color: #f4f4f4;
            text-align: center;
            margin: 0;
            padding: 0;
        }

        .container {
            max-width: 800px;
            margin: 0 auto;
            background-color: #fff;
            padding: 20px;
            border-radius: 5px;
            box-shadow: 0 0 10px rgba(0, 0, 0, 0.2);
        }

        h2 {
            color: #333;
        }

        h3 {
            margin-top: 20px;
            color: #555;
        }

        p {
            margin: 10px 0;
            color: #666;
        }

        button {
            background-color: #007BFF;
            color: #fff;
            padding: 10px 20px;
            border: none;
            border-radius: 5px;
            cursor: pointer;
        }

        button a {
            text-decoration: none;
            color: #fff;
        }

        button:hover {
            background-color: #0056b3;
        }

        hr {
            margin-top: 20px;
        }
    </style>
</head>
<body>
    <div class="container">
        <?php
        session_start();

        if (!isset($_SESSION['user_id']) || !isset($_SESSION['user_type'])) {
            header("Location: login.php");
            exit();
        }

        $user_id = $_SESSION['user_id'];
        $user_type = $_SESSION['user_type'];

        $servername = "localhost";
        $username = "root";
        $password = "";
        $database = "healthcare";

        $conn = new mysqli($servername, $username, $password, $database);

        if ($conn->connect_error) {
            die("Connection failed: " . $conn->connect_error);
        }

        if ($user_type == 'doctors') {
            $sql = "SELECT * FROM doctors";
            $result = $conn->query($sql);

            if ($result->num_rows > 0) {
                echo "<h2>Welcome, $user_type</h2>";
                echo "<h3>Doctor Details:</h3>";

                while ($row = $result->fetch_assoc()) {
                    echo "<p>Doctor's Name: {$row['full_name']}</p>";
                    echo "<p>Phone Number: {$row['phone_number']}</p>";
                    echo "<p>City: {$row['city']}</p>";
                    echo "<p>Specialization: {$row['specialization']}</p>";
                    echo "<p>Booking Info: {$row['booking_info']}</p>";
                    echo "<hr>";
                }
            } else {
                echo "<p>No doctor details found.</p>";
            }
        } elseif ($user_type == 'patients') {
            $sql = "SELECT * FROM doctors";
            $result = $conn->query($sql);

            if ($result->num_rows > 0) {
                echo "<h2>Welcome, $user_type</h2>";

                while ($row = $result->fetch_assoc()) {
                    echo "<h3>Doctor Details:</h3>";
                    echo "<p>Doctor's Name: {$row['full_name']}</p>";
                    echo "<p>Phone Number: {$row['phone_number']}</p>";
                    echo "<p>City: {$row['city']}</p>";
                    echo "<p>Specialization: {$row['specialization']}</p>";
                    echo "<p>Booking Info: {$row['booking_info']}</p>";

                    if ($user_type == 'patients') {
                        // Add a link to the appointment form for each doctor
                        echo "<button><a href='appointment.php?doctor_name={$row['full_name']}'>Book Me</a></button>";
                    }

                    echo "<hr>";
                }
            } else {
                echo "<p>No doctor details found.</p>";
            }
        }

        $conn->close();
        ?>
    </div>
</body>
</html>
