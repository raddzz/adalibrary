<?php
include ('../config.php');

 include '../plugins/phpmailer/phpmailer.php';
    include '../plugins/phpmailer/smtp.php';
    include '../plugins/phpmailer/Exception.php';
    use PHPMailer\PHPMailer\PHPMailer;
    use PHPMailer\PHPMailer\SMTP;
    use PHPMailer\PHPMailer\Exception;

$userauthid = mysqli_real_escape_string($conn, $_POST['userid']);
$isbn = mysqli_real_escape_string($conn, $_POST['barcode']);
$dateTime = mysqli_real_escape_string($conn, $_POST['dateAndTime']);
$nowdatetime = gmdate('d/m/Y h:i:s A');

$sql = "SELECT * FROM users WHERE authkey = $userauthid";
$result = $conn->query($sql);
$row = $result->fetch_assoc();
$email =  $row["email"];
$fname =  $row["firstname"];
$lname =  $row["lastname"];
$uid = $row["userid"];
$sql = "SELECT * FROM books WHERE isbn = $isbn AND status = 'NOTLOANED'";
$result = $conn->query($sql);
$row = $result->fetch_assoc();
$title =  $row["title"];

if ($result->num_rows > 0) {
    $sql = "INSERT INTO lends (targetbook, lendee, lender, status, nowdatetime, enddatetime) VALUES ('$isbn', '$uid', '$uid', 'LOANED', '$nowdatetime', '$dateTime')";
    if ($conn->query($sql) === TRUE) {      
    $sql = "UPDATE books SET status = 'LOANED', lenderid = $uid WHERE isbn = $isbn";
    if ($conn->query($sql) === TRUE) {
    
   
    //Create a new PHPMailer instance
    $mail = new PHPMailer;
    //Tell PHPMailer to use SMTP
    $mail->isSMTP();
    //Enable SMTP debugging
    // SMTP::DEBUG_OFF = off (for production use)
    // SMTP::DEBUG_CLIENT = client messages
    // SMTP::DEBUG_SERVER = client and server messages
    $mail->SMTPDebug = SMTP::DEBUG_OFF;
    //Set the hostname of the mail server
    $mail->Host = 'smtp.gmail.com';
    // use
    // $mail->Host = gethostbyname('smtp.gmail.com');
    // if your network does not support SMTP over IPv6
    //Set the SMTP port number - 587 for authenticated TLS, a.k.a. RFC4409 SMTP submission
    $mail->Port = 587;
    //Set the encryption mechanism to use - STARTTLS or SMTPS
    $mail->SMTPSecure = PHPMailer::ENCRYPTION_STARTTLS;
    //Whether to use SMTP authentication
    $mail->SMTPAuth = true;
    //Username to use for SMTP authentication - use full email address for gmail
    $mail->Username = $emailuser;
    //Password to use for SMTP authentication
    $mail->Password = $emailpassword;
    //Set who the message is to be sent from
    $mail->setFrom('', 'Library');  //Set who the message is to be sent to
    $mail->addAddress($email, $fname+$lname);
    //Set the subject line
    $mail->Subject = 'Book lend - '. $title .'';
    ob_start();

    // Include a file here or insert the code that generate the HTML
    // Example
    include('../emails/newlend.php');

    $body = ob_get_contents();
    ob_end_clean();

    $mail->Body = $body;
    $mail->AltBody = 'This message must be viewed in a HTML reader';
    //send the message, check for errors
    if (!$mail->send()) {
        echo 'Mailer Error: '. $mail->ErrorInfo;
    } else {
        echo 'Message sent!';

}
    }
    //header("Location: /?page=lendbook&callback=success");
    } else {
        echo !extension_loaded('openssl')?"Not Available":"Available";

    echo "Error: " . $sql . "<br>" . $conn->error;
    }    
}
else{
    header("Location: /?page=lendbook&callback=fail1");
}