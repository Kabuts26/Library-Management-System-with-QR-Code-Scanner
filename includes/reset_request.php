<?php

use PHPMailer\PHPMailer\PHPMailer;
use PHPMailer\PHPMailer\Exception;
require '../PHPMailer/src/Exception.php';
require '../PHPMailer/src/PHPMailer.php';
require '../PHPMailer/src/SMTP.php';

if (isset($_POST["reset-request-submit"])) {

    require '../database/dbcon.php'; 
    // Check if email does exist
    $userEmail = $_POST["email"]; 


    $sql = "SELECT * FROM user WHERE email=?";
    $stmt = mysqli_stmt_init($con);

    mysqli_stmt_prepare($stmt, $sql);

        mysqli_stmt_bind_param($stmt, "s", $userEmail);
        mysqli_stmt_execute($stmt);

        $result = mysqli_stmt_get_result($stmt); 
        if (!$row = mysqli_fetch_assoc($result)) {
            header("Location: ../forgot_password.php?reset=emailnotfound"); 
            exit();
        }
    
    $selector = bin2hex(random_bytes(8));
    $token = random_bytes(32); 

    $url ="http://localhost/library_update/create_new_pass.php?selector=" . $selector . "&validator=" . bin2hex($token); 

    $expires = date("U") + 1800; 

    $sql = "DELETE FROM pass_reset WHERE reset_email=?";
    $stmt = mysqli_stmt_init($con);
    if (!mysqli_stmt_prepare($stmt, $sql)) {
        echo "There was an error!";
        exit();
    } else {
        mysqli_stmt_bind_param($stmt, "s", $userEmail);
        mysqli_stmt_execute($stmt);
    }

    $sql = "INSERT INTO pass_reset (reset_email, reset_selector, reset_token, reset_expires) VALUES (?,?,?,?);";

    $stmt = mysqli_stmt_init($con);
    if (!mysqli_stmt_prepare($stmt, $sql)) {
        echo "There was an error!";
        exit();
    } else {
        $hashedToken = password_hash($token, PASSWORD_DEFAULT);
        mysqli_stmt_bind_param($stmt, "ssss", $userEmail, $selector, $hashedToken, $expires);
        mysqli_stmt_execute($stmt);
    }

    mysqli_stmt_close($stmt);
    mysqli_close($con);

    $to = $userEmail;

    $subject ='Reset your password';

    $message = '<p>We received a password reset request. Click the link to reset your password. If you did not make this request, ignore this email.</p>';
    $message .= '<p>Below is your password reset link: <br>';
    $message .= '<a href ="' . $url . '">' . $url . '</a></p>';

    // $headers = "From: librarymanagementsystem\r\n";
    // $headers .= "Reply to: librarymanagementsystem\r\n";
    // $headers .= "Content-type: text/html\r\n";

    // Send MAIL
    $mail = new PHPMailer(true);
    $mail->IsSMTP();
    $mail->Mailer = "smtp";
    $mail->SMTPDebug = 1;
    $mail->SMTPAuth = TRUE;
    $mail->SMTPSecure = "tls";
    $mail->Port = 587;
    $mail->Host = "smtp.gmail.com";
    $mail->Username = "email.demo008@gmail.com";
    $mail->Password = "jwsuykjuceskqlte";

    //Recipients
    $mail->IsHTML(true);
    $mail->AddAddress($to, $to);
    $mail->SetFrom("email.demo008@gmail.com", "LMS");
    $mail->Subject = $subject;

    //Content
    $mail->Body = $message;

    if ($mail->send()) {
        header("Location: ../forgot_password.php?reset=success"); 
    } else {
        header("Location: ../forgot_password.php?reset=error"); 
    }


} else {
    header("Location: ../index.php");
}