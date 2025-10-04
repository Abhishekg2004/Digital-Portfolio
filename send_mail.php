<?php
include 'db.php'; // Your DB connection file

header('Content-Type: application/json');
error_reporting(E_ALL);
ini_set('display_errors', 1);

require 'PHPMailer/src/PHPMailer.php';
require 'PHPMailer/src/SMTP.php';
require 'PHPMailer/src/Exception.php';

use PHPMailer\PHPMailer\PHPMailer;
use PHPMailer\PHPMailer\Exception;

// --- DB Config ---

//$servername = "localhost";
//$username = "root"; // XAMPP default
//$password = "";     // XAMPP default
//$dbname = "portfolio";

// --- Connect to DB ---
$conn = new mysqli($servername, $username, $password, $dbname);
if ($conn->connect_error) {
    echo json_encode([
        "success" => false,
        "checkpoint" => "DB connection failed",
        "error" => $conn->connect_error
    ]);
    exit();
}

// --- Check POST Data ---
if ($_SERVER['REQUEST_METHOD'] === 'POST') {

    $name = $_POST['name'] ?? '';
    $email = $_POST['email'] ?? '';
    $message = $_POST['message'] ?? '';

    if(empty($name) || empty($email) || empty($message)){
        echo json_encode([
            "success" => false,
            "checkpoint" => "Validation failed",
            "data" => compact('name','email','message')
        ]);
        exit();
    }

    // --- Insert into DB ---
    $stmt = $conn->prepare("INSERT INTO contact_messages (name, email, message) VALUES (?, ?, ?)");
    if(!$stmt){
        echo json_encode([
            "success" => false,
            "checkpoint" => "Prepare failed",
            "error" => $conn->error
        ]);
        exit();
    }

    $stmt->bind_param("sss", $name, $email, $message);

    if(!$stmt->execute()){
        echo json_encode([
            "success" => false,
            "checkpoint" => "Execute failed",
            "error" => $stmt->error
        ]);
        exit();
    }

    $stmt->close();

    // --- Send Email ---
    $mail = new PHPMailer(true);
    try {
        $mail->isSMTP();
        $mail->Host       = "smtp.gmail.com";
        $mail->SMTPAuth   = true;
        $mail->Username   = "yormail@gmail.com";  
        $mail->Password   = "pamw glzw thsf vsml"; // App password
        $mail->SMTPSecure = "tls";
        $mail->Port       = 587;

        $mail->setFrom("yormail@gmail.com", "Portfolio Contact Form");
        $mail->addAddress("yormail@gmail.com", "Portfolio Owner");

        $mail->isHTML(true);
        $mail->Subject = "New Contact Message from $name";
        $mail->Body    = "<b>Name:</b> $name <br><b>Email:</b> $email <br><b>Message:</b><br>$message";

        $mail->send();

        echo json_encode([
            "success" => true,
            "checkpoint" => "DB inserted and Mail sent"
        ]);

    } catch (Exception $e) {
        echo json_encode([
            "success" => false,
            "checkpoint" => "Mailer error",
            "error" => $mail->ErrorInfo
        ]);
    }

    $conn->close();

} else {
    echo json_encode([
        "success" => false,
        "checkpoint" => "Invalid request method"
    ]);
}
?>
