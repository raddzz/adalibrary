<?php
include 'config.php';
//response array 
	$response = array(); 
	
	$apikey = $_GET['key'];

	$sql = "SELECT * FROM users WHERE apikey = '$apikey'";
$result = $conn->query($sql);

if ($result->num_rows > 0) {
    // output data of each row
    $row = $result->fetch_assoc();

      $firstname =  $row["firstname"];
      $lastname =  $row["lastname"];
      $emailaddress =  $row["email"];
      $uid =  $row["userid"];
      $status =  $row["status"];

    }
	if(isset($_GET['op'])){
		
		//switching the get op value 
		switch($_GET['op']){
			
			//if it is add artist 
			//that means we will add an artist 
			case 'lend':
				$userauthid = mysqli_real_escape_string($conn, $uid);
				$isbn = mysqli_real_escape_string($conn, $_POST['isbn']);
				$dateTime = gmdate('d/m/Y h:i:s A');
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
				    	$response['error'] = false;
						$response['message'] = 'Book lended successfully';}}}
				else{
					$response['error'] = true;
						$response['message'] = 'Book lent or not in system';
				}
			break; 
			
			case 'return':
				$isbn = mysqli_real_escape_string($conn, $_POST['isbn']);

				$sql = "SELECT * FROM books WHERE isbn = $isbn AND status = 'LOANED'";
				$result = $conn->query($sql);
				$row = $result->fetch_assoc();

				if ($result->num_rows > 0) {
					$sql = "UPDATE LENDS SET status = 'FINISHED' WHERE targetbook = $isbn";
				    if ($conn->query($sql) === TRUE) {    	
				    $sql = "UPDATE books SET status = 'NOTLOANED', lenderid = 0 WHERE isbn = $isbn";
				    if ($conn->query($sql) === TRUE) {
				    	$response['error'] = false;
						$response['message'] = 'Book returned successfully';
													}
				    							}
				    
				    else {
				    $response['error'] = true;
						$response['message'] = 'Book not lent or not in system';
				    }    
				}else {
				    $response['error'] = true;
						$response['message'] = 'Book not lent or not in system';
				    }    
			break; 
			
			default:
				$response['error'] = true;
				$response['message'] = 'No operation to perform';
			
		}
		
	}else{
		$response['error'] = false; 
		$response['message'] = 'Invalid Request';
	}
	
	//displaying the data in json 
	echo json_encode($response);