<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Complaint Management System</title>
    <style>
        body {
            font-family: Arial, sans-serif;
            line-height: 1.6;
            background-color: #f0f0f0;
            padding: 20px;
        }
        .container {
            max-width: 600px;
            background-color: #fff;
            padding: 20px;
            margin: 20px auto;
            border-radius: 8px;
            box-shadow: 0 0 10px rgba(0,0,0,0.1);
        }
        .complaint {
            margin-bottom: 20px;
            padding-bottom: 10px;
            border-bottom: 1px solid #ccc;
        }
    </style>
</head>
<body>
    <div class="container">
        <h2>Complaint Management System</h2>
        <h3>Submit a Complaint</h3>
        <form action="index.php" method="post">
            <label for="name">Name:</label><br>
            <input type="text" id="name" name="name" required><br><br>
            <label for="email">Email:</label><br>
            <input type="email" id="email" name="email" required><br><br>
            <label for="complaint">Complaint:</label><br>
            <textarea id="complaint" name="complaint" rows="4" required></textarea><br><br>
            <input type="submit" value="Submit Complaint">
        </form>

        <h3>Existing Complaints</h3>
        <?php
        // Database connection
        $host = 'localhost';  // Database host
        $user = 'root';       // Database username
        $password = '';       // Database password
        $dbname = 'complaints'; // Database name

        $conn = new mysqli($host, $user, $password, $dbname);

        if ($conn->connect_error) {
            die("Connection failed: " . $conn->connect_error);
        }

        // Handle form submission
        if ($_SERVER["REQUEST_METHOD"] == "POST") {
            $name = $_POST['name'];
            $email = $_POST['email'];
            $complaint = $_POST['complaint'];

            $sql = "INSERT INTO complaints_table (name, email, complaint_text) VALUES ('$name', '$email', '$complaint')";

            if ($conn->query($sql) === TRUE) {
                echo "<p>Complaint submitted successfully!</p>";
            } else {
                echo "Error: " . $sql . "<br>" . $conn->error;
            }
        }

        // Display existing complaints
        $sql = "SELECT * FROM complaints_table ORDER BY created_at DESC";
        $result = $conn->query($sql);

        if ($result->num_rows > 0) {
            while($row = $result->fetch_assoc()) {
                echo '<div class="complaint">';
                echo '<strong>Name:</strong> ' . htmlspecialchars($row['name']) . '<br>';
                echo '<strong>Email:</strong> ' . htmlspecialchars($row['email']) . '<br>';
                echo '<strong>Complaint:</strong><br>' . nl2br(htmlspecialchars($row['complaint_text'])) . '<br>';
                echo '<em>Submitted at ' . $row['created_at'] . '</em>';
                echo '</div>';
            }
        } else {
            echo "<p>No complaints submitted yet.</p>";
        }

        $conn->close();
        ?>
    </div>
</body>
</html>
