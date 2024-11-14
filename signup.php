<?php
header("Content-Type: application/json");

$servername = "localhost";
$username = "root";
$password = ""; 
$dbname = "test"; 

// Get the JSON input data
$data = json_decode(file_get_contents("php://input"), true);

if ($data) {
    $firstname = $data['firstname'];
    $lastname = $data['lastname'];
    $email = $data['email'];
    $company = $data['company'];

    // Database connection
    $conn = new mysqli($servername, $username, $password, $dbname);

    // Check connection
    if ($conn->connect_error) {
        echo json_encode(["message" => "Database connection failed: " . $conn->connect_error]);
        exit();
    }

    // Prepare and execute SQL statement
    $stmt = $conn->prepare("INSERT INTO users (firstname, lastname, email, company) VALUES (?, ?, ?, ?)");
    $stmt->bind_param("ssss", $firstname, $lastname, $email, $company);

    if ($stmt->execute()) {
        echo json_encode(["message" => "Signup successful!"]);
    } else {
        echo json_encode(["message" => "Error: " . $stmt->error]);
    }

    $stmt->close();
    $conn->close();
} else {
    echo json_encode(["message" => "Invalid input data."]);
}
?>
