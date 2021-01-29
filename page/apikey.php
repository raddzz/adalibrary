<?php
$key = strtolower(md5(microtime().rand(1000, 9999)));
$uid = mysqli_real_escape_string($conn, $_GET["userid"]);

$sql = "UPDATE users SET apikey = '$key' WHERE userid = $uid";
    if ($conn->query($sql) === TRUE) {
    
	header("Location: ?page=personinfo&userid=$uid");
									}
    							
    
    else {
    echo "Error: " . $sql . "<br>" . $conn->error;
    }    