<?php
// Create connection
$conn = new mysqli($servername, $username, $password, $dbname);
// Check connection
if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}
?>



<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="utf-8">
  <meta name="viewport" content="width=device-width, initial-scale=1">
  <meta http-equiv="x-ua-compatible" content="ie=edge">

  <title>Ada Library - Lend Book</title>

  <!-- Font Awesome Icons -->
  <link rel="stylesheet" href="plugins/fontawesome-free/css/all.min.css">
  <!-- Theme style -->
  <link rel="stylesheet" href="dist/css/adminlte.min.css">
  <!-- Google Font: Source Sans Pro -->
  <link href="https://fonts.googleapis.com/css?family=Source+Sans+Pro:300,400,400i,700" rel="stylesheet">
  <link rel="stylesheet" href="plugins/daterangepicker/daterangepicker.css">
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
        <a href="/?page=lendbook" class="nav-link">Lend Book</a>
      </li>
      <!-- SEARCH FORM -->
    <form class="form-inline ml-3" action="?page=booklookup" method="get">
      <div class="input-group input-group-sm">
        <input class="form-control form-control-navbar" autocomplete="off" name="barcode" type="search" placeholder="Book Lookup" aria-label="Search">
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
            <a href="?page=lendbook" class="nav-link active">
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
            <h1 class="m-0 text-dark">Lend Book</h1>
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
            <div class="card card-primary">
              <!-- form start -->
              <form role="form" action="forms/lendbook.php" method="post">
                <div class="card-body">
                  <div class="form-group">
                    <label for="userid">User ID</label>
                    <input type="text" class="form-control" required autocomplete="off" name="userid" id="userid" onkeyup="nameLookup(this.value)">
                  </div>
                  <div class="form-group">
                    <label for="nameDisplay">Name</label>
                    <input type="text" class="form-control" name="nameDisplay" placeholder="Enter User ID" id="nameDisplay" disabled>
                  </div>
                  <div class="form-group">
                    <label for="barcode">Scan Barcode</label>
                    <input type="text" class="form-control" required autocomplete="off" name="barcode" id="barcode" onkeyup="bookLookup(this.value)">
                  </div>                  
                  <div class="form-group">
                    <label for="bookDisplay">Book</label>
                    <input type="text" class="form-control" required name="bookDisplay" placeholder="Scan Barcode" id="bookDisplay" disabled>
                  </div>
                <div class="form-group">
                  <label for="dateAndTime">Due date and time</label>
                  <div class="input-group">
                    <div class="input-group-prepend">
                      <span class="input-group-text"><i class="far fa-clock"></i></span>
                    </div>
                    <input type="text" class="form-control" id="dateAndTime" name="dateAndTime">
                  </div>
                </div>
                <!-- /.card-body -->

                <div class="card-footer">
                  <button type="submit" value="Lend Book" class="btn btn-primary">Lend Book</button>
                </div>
                  <?php if (isset($_GET["callback"])) {
                  if ($_GET{"callback"} == "success") {
                    ?><div class="callout callout-success">
                  <h5>Book successfully lent!!</h5>

                  <p>Thank you.</p>
                </div><?php
                  }
                  elseif ($_GET["callback"] == "fail1") {
                    ?><div class="callout callout-danger">
                  <h5>Book already Lent out</h5>

                  <p>Please check book status</p>
                </div><?php
                  }
                }?>

                </div>
              </form>
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
<script src="plugins/moment/moment.min.js"></script>
<script src="plugins/daterangepicker/daterangepicker.js"></script>
<script>
function nameLookup(str) {
    if (str.length == 0) {
        document.getElementById("nameDisplay").innerHTML = "";
        return;
    } else {
        var xmlhttp = new XMLHttpRequest();
        xmlhttp.onreadystatechange = function() {
            if (this.readyState == 4 && this.status == 200) {
                document.getElementsByName('nameDisplay')[0].placeholder= this.responseText;
            }
        };
        xmlhttp.open("GET", "ajax/namelookup.php?q=" + str, true);
        xmlhttp.send();
    }
}
</script>
<script>
function bookLookup(str) {
    if (str.length == 0) {
        document.getElementById("bookDisplay").innerHTML = "";
        return;
    } else {
        var xmlhttp = new XMLHttpRequest();
        xmlhttp.onreadystatechange = function() {
            if (this.readyState == 4 && this.status == 200) {
                document.getElementsByName('bookDisplay')[0].placeholder= this.responseText;
            }
        };
        xmlhttp.open("GET", "ajax/booklookup.php?q=" + str, true);
        xmlhttp.send();
    }
}
</script>
<script>
  function nextweek(){
    var today = new Date();
    var nextweek = new Date(today.getFullYear(), today.getMonth(), today.getDate()+8);
    return nextweek;
}
</script>
<script>
  $(document).ready(function() {
  $(window).keydown(function(event){
    if(event.keyCode == 13) {
      event.preventDefault();
      return false;
    }
  });
});
</script>
<script>
    $('#dateAndTime').daterangepicker({
      timePicker: true,
      timePickerIncrement: 30,
      singleDatePicker: true,
      minDate: new Date(),
      maxDate: nextweek(),
      startDate: nextweek(),
      drops: 'up',

      locale: {
        format: 'DD/MM/YYYY hh:mm A'
      }
    })
</script>
</body>
</html>
