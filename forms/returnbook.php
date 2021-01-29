<?php
include ('../config.php');

$isbn = mysqli_real_escape_string($conn, $_POST['barcode']);

$sql = "SELECT * FROM books WHERE isbn = $isbn AND status = 'LOANED'";
$result = $conn->query($sql);
$row = $result->fetch_assoc();

if ($result->num_rows > 0) {
	$sql = "UPDATE LENDS SET status = 'FINISHED' WHERE targetbook = $isbn";
    if ($conn->query($sql) === TRUE) {    	
    $sql = "UPDATE books SET status = 'NOTLOANED', lenderid = 0 WHERE isbn = $isbn";
    if ($conn->query($sql) === TRUE) {
    
	header("Location: /?page=returnbook&callback=success");
									}
    							}
    
    else {
    echo "Error: " . $sql . "<br>" . $conn->error;
    }    
}
else{
	header("Location: /?page=returnbook&callback=notlent");
}