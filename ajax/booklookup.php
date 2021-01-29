<?php
include ('../config.php');

// get the q parameter from URL
$q = $_REQUEST["q"];

if (!is_numeric($q)) {
            echo "Not a number"; die;}
            else {
              $q = mysqli_real_escape_string($conn, $q);
            }


$sql = "SELECT * FROM books WHERE isbn = $q";
$result = $conn->query($sql);

if ($result->num_rows > 0) {
    // output data of each row
    $row = $result->fetch_assoc();

      $isbn =  $row["isbn"];
      $title =  $row["title"];
      $author =  $row["author"];

      echo $title,", ",$author;
}
else{
echo "No results found";
}
?>