<?php
session_start();

// Database configuration
$servername = "localhost";
$username = "root";
$password = "";
$dbname = "users_database";

// Konek database
$conn = new mysqli($servername, $username, $password, $dbname);

// Check connection
if ($conn->connect_error) {
    die("Gagal konek: " . $conn->connect_error);
}

// Handle form submission
if ($_SERVER["REQUEST_METHOD"] == "POST") {
  $email = $_POST['email'];
  $password = $_POST['password'];

  // Insert data into the database
  $sql = "INSERT INTO users_list (email, password) VALUES (?, ?)";
  $stmt = $conn->prepare($sql);

  if ($stmt) {
      $stmt->bind_param("ss", $email, $password);

      if ($stmt->execute()) {
          // Store email in session
          $_SESSION['email'] = $email;
          echo "<div>Account created successfully! Welcome, " . $_SESSION['email'] . ".</div>";

          // Redirect to a dashboard or welcome page
          header("Location: Dafa_Dashboard.html");
          exit();
      } else {
          echo "<div>Error: " . $stmt->error . "</div>";
      }

      $stmt->close();
  } else {
      echo "<div>Failed to prepare statement: " . $conn->error . "</div>";
  }
}

// Disconnect
$conn->close();
?>
