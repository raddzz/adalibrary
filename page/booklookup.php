<?php
if (!isset($_GET["barcode"])) {
http_response_code(404);
die();
}

if (!is_numeric($_GET["barcode"])) {
            echo "Not a barcode";
            ?>
            <form class="form-inline ml-3" action="?page=booklookup" method="get">
      <div class="input-group input-group-sm">
        <input class="form-control form-control-navbar" autofocus autocomplete="off" name="barcode" type="search" placeholder="Book Lookup" aria-label="Search">
        <input type="hidden" name="page" id="page" value="booklookup">
        <div class="input-group-append">
          <input class="btn btn-navbar" type="submit">
          </input>
        </div>

      </div>
    </form> <?php
            die;}
            else {
              $isbn = mysqli_real_escape_string($conn, $_GET["barcode"]);
            }


$sql = "SELECT * FROM books WHERE isbn = $isbn";
$result = $conn->query($sql);

if ($result->num_rows > 0) {
    // output data of each row
    $row = $result->fetch_assoc();

      $isbn =  $row["isbn"];
      $title =  $row["title"];
      $authors =  $row["author"];
      $thumbnail =  $row["imageurl"];

    
} else {
    $url = "https://www.googleapis.com/books/v1/volumes?q=isbn:".$isbn."&key=".$googleBooksAPIKey;
    $response = file_get_contents($url);
    $data = json_decode($response, true);

    $results = mysqli_real_escape_string($conn, $data['totalItems']);

    if ($results == 0){
    echo "NOT FOUND";
    ?>
            <form class="form-inline ml-3" action="?page=booklookup" method="get">
      <div class="input-group input-group-sm">
        <input class="form-control form-control-navbar" autofocus autocomplete="off" name="barcode" type="search" placeholder="Book Lookup" aria-label="Search">
        <input type="hidden" name="page" id="page" value="booklookup">
        <div class="input-group-append">
          <input class="btn btn-navbar" type="submit">
          </input>
        </div>

      </div>
    </form> <?php
    die;
    }

    $title = mysqli_real_escape_string($conn, $data['items'][0]['volumeInfo']['title']);
    $authors = mysqli_real_escape_string($conn, $data['items'][0]['volumeInfo']['authors'][0]);
    $thumbnail = mysqli_real_escape_string($conn, $data['items'][0]['volumeInfo']['imageLinks']['thumbnail']);
    $sql = "INSERT INTO books (isbn, title, author, imageurl, status) VALUES ('$isbn', '$title', '$authors', '$thumbnail','NOTLOANED')";

    if ($conn->query($sql) === TRUE) {
    echo "New record created successfully";
    header("Refresh:1");
    } else {
    echo "Error: " . $sql . "<br>" . $conn->error;
    }


}
$conn->close();
?>



<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="utf-8">
  <meta name="viewport" content="width=device-width, initial-scale=1">
  <meta http-equiv="x-ua-compatible" content="ie=edge">

  <title>Ada Library - Book lookup</title>

  <!-- Font Awesome Icons -->
  <link rel="stylesheet" href="plugins/fontawesome-free/css/all.min.css">
  <!-- Theme style -->
  <link rel="stylesheet" href="dist/css/adminlte.min.css">
  <!-- Google Font: Source Sans Pro -->
  <link href="https://fonts.googleapis.com/css?family=Source+Sans+Pro:300,400,400i,700" rel="stylesheet">
</head>
<body class="hold-transition sidebar-mini layout-fixed">
<div class="wrapper">

  <!-- Navbar -->
  <nav class="main-header navbar navbar-expand navbar-white navbar-light">
    <!-- Left navbar links -->
    <ul class="navbar-nav">
      <li class="nav-item">
        <a class="nav-link" data-widget="pushmenu" href="#"><i class="fas fa-bars"></i></a>
      </li>
      <li class="nav-item d-none d-sm-inline-block active">
        <a href="/>page=booklookup" class="nav-link">Book Lookup</a>
      </li>
      <!-- SEARCH FORM -->
    <form class="form-inline ml-3" action="?page=booklookup" method="get">
      <div class="input-group input-group-sm">
        <input class="form-control form-control-navbar" autofocus autocomplete="off" name="barcode" type="search" placeholder="Book Lookup" aria-label="Search">
        <input type="hidden" name="page" id="page" value="booklookup">
        <div class="input-group-append">
          <input class="btn btn-navbar" type="submit">
          </input>
        </div>

      </div>
    </form>
    </ul>      
  </nav>
  <!-- /.navbar -->

  <!-- Main Sidebar Container -->
  <aside class="main-sidebar sidebar-dark-primary elevation-4">
    <!-- Brand Logo -->
    <a href="/" class="brand-link">
      <img src="img/ncds.jpg" alt="AdminLTE Logo" class="brand-image img-circle elevation-3"
           style="">
      <span class="brand-text font-weight-light">Ada Library</span>
    </a>

    <!-- Sidebar -->
    <div class="sidebar">
      <!-- Sidebar user panel (optional) -->
      <div class="user-panel mt-3 pb-3 mb-3 d-flex">
        <?php include 'includes/loggedin.php';?>
      </div>

      <!-- Sidebar Menu -->
      <nav class="mt-2">
        <ul class="nav nav-pills nav-sidebar flex-column" data-widget="treeview" role="menu" data-accordion="false">
         <li class="nav-item">
            <a href="/" class="nav-link">
              <i class="nav-icon fas fa-home"></i>
              <p>
                Home
              </p>
            </a>
          </li>
          <li class="nav-item">
            <a href="?page=lendbook" class="nav-link">
              <i class="nav-icon fas fa-book-reader"></i>
              <p>
                Lend Book
              </p>
            </a>
          </li>
          <li class="nav-item">
            <a href="?page=returnbook" class="nav-link">
              <i class="nav-icon fas fa-book-dead"></i>
              <p>
                Return Book
              </p>
            </a>
          </li>
          <li class="nav-item has-treeview menu-closed">
            <a href="?page=management" class="nav-link">
              <i class="nav-icon fas fa-cogs"></i>
              <p>
                Management
                <i class="right fas fa-angle-left"></i>
              </p>
            </a>
            <ul class="nav nav-treeview">
              <li class="nav-item">
                <a href="?page=people" class="nav-link">
                  <i class="far fa-id-card nav-icon"></i>
                  <p>Manage People</p>
                </a>
              </li>
              			<li class="nav-item">
                <a href="?page=books" class="nav-link">
                  <i class="fas fa-book nav-icon"></i>
                  <p>Manage Books</p>
                </a>
              </li>
              <li class="nav-item">
                <a href="?page=lends" class="nav-link">
                  <i class="fas fa-calendar-week nav-icon"></i>
                  <p>Manage Lends</p>
                </a>
              </li>
            </ul>
          </li>
        </ul>
      </nav>
      <!-- /.sidebar-menu -->
    </div>
    <!-- /.sidebar -->
  </aside>

  <!-- Content Wrapper. Contains page content -->
  <div class="content-wrapper">
    <!-- Content Header (Page header) -->
    <div class="content-header">
      <div class="container-fluid">
        <div class="row mb-2">
          <div class="col-sm-6">
            <h1 class="m-0 text-dark">Book Lookup - <?php echo $title ?></h1>
          </div><!-- /.col -->
        </div><!-- /.row -->
      </div><!-- /.container-fluid -->
    </div>
    <!-- /.content-header -->

    <!-- Main content -->
    <div class="content">
      <div class="container-fluid">
        <div class="row">
          <div class="col-lg-6"> 
          <div class="card-body">
                <table class="table table-bordered">
                  <tbody>
                    <tr>
                      <td>ISBN</td>
                      <td><?php echo $isbn;?></td>
                    </tr>
                    <tr>
                      <td>Title</td>
                      <td><?php echo $title;?></td>
                    </tr>
                    <tr>
                      <td>Authors</td>
                      <td><?php echo $authors;?></td>
                    </tr>
                    <tr>
                      <td></td>
                      <td><img src="<?php echo $thumbnail;?>" > </td>
                    </tr>
                  </tbody>
                </table>
              </div>
          </div>
        </div>
        <!-- /.row -->
      </div><!-- /.container-fluid -->
    </div>
    <!-- /.content -->
  </div>
  <!-- /.content-wrapper -->

  <!-- Main Footer -->
  <footer class="main-footer">
    <!-- To the right -->
    <div class="float-right d-none d-sm-inline">
      BETA 0.1
    </div>
    <!-- Default to the left -->
  </footer>
</div>
<!-- ./wrapper -->

<!-- REQUIRED SCRIPTS -->

<!-- jQuery -->
<script src="plugins/jquery/jquery.min.js"></script>
<!-- Bootstrap 4 -->
<script src="plugins/bootstrap/js/bootstrap.bundle.min.js"></script>
<!-- AdminLTE App -->
<script src="dist/js/adminlte.min.js"></script>
</body>
</html>
