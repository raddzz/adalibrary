<?php

include 'config.php';
if (isset($_GET["page"])) {
if ($_GET["page"] == "booklookup") {
    include("page/booklookup.php");
}
elseif ($_GET["page"] == "books") {
    include("page/managebooks.php");
}
elseif ($_GET["page"] == "people") {
    include("page/managepeople.php");
}
elseif ($_GET["page"] == "lendbook") {
    include("page/lendbook.php");
}
elseif ($_GET["page"] == "returnbook") {
    include("page/returnbook.php");
}
elseif ($_GET["page"] == "auth") {
    include("page/auth.php");
}
elseif ($_GET["page"] == "personinfo") {
    include("page/personinfo.php");
}
elseif ($_GET["page"] == "generateapikey") {
    include("page/apikey.php");
}
else{

http_response_code(404);
}
}
else {?>
<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="utf-8">
  <meta name="viewport" content="width=device-width, initial-scale=1">
  <meta http-equiv="x-ua-compatible" content="ie=edge">

  <title>Ada Library - Home</title>

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
        <a href="/" class="nav-link">Home</a>
      </li>
      <!-- SEARCH FORM -->
    <form class="form-inline ml-3" action="index.php" method="get">
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
            <a href="/" class="nav-link active">
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
            <h1 class="m-0 text-dark">Home Page</h1>
          </div><!-- /.col -->
        </div><!-- /.row -->
      </div><!-- /.container-fluid -->
    </div>
    <!-- /.content-header -->

    <!-- Main content -->
    <div class="content">
      <div class="container-fluid">
        <div class="row">
          <div class="col-lg-3">
            <div class="small-box bg-info">
              <div class="inner">
                <h3><?php
                $sql = "SELECT * FROM books";
                $result = $conn->query($sql);

                echo $result->num_rows;

                ?></h3>

                <p>Books in system</p>
              </div>
              <div class="icon">
                <i class="fas fa-book"></i>
              </div>
              <a href="?page=books" class="small-box-footer">
                More info <i class="fas fa-arrow-circle-right"></i>
              </a>
            </div>
            <div class="small-box bg-warning">
              <div class="inner">
                <h3><?php
                $sql = "SELECT * FROM books WHERE status = 'loaned'";
                $result = $conn->query($sql);

                echo $result->num_rows;

                ?></h3>

                <p>Books currently lent</p>
              </div>
              <div class="icon">
                <i class="fas fa-book-reader"></i>
              </div>
              <a href="?page=books" class="small-box-footer">
                More info <i class="fas fa-arrow-circle-right"></i>
              </a>
            </div>
            <div class="small-box bg-success">
              <div class="inner">
                <h3><?php
                $sql = "SELECT * FROM users WHERE status ='active'";
                $result = $conn->query($sql);

                echo $result->num_rows;

                ?></h3>

                <p>Active users</p>
              </div>
              <div class="icon">
                <i class="fas fa-male"></i>
              </div>
              <a href="?page=people" class="small-box-footer">
                More info <i class="fas fa-arrow-circle-right"></i>
              </a>
            </div>
          </div>

          <div class="col-lg-3">
            <a class="btn btn-app" href="?page=lendbook">
                  <i class="fas fa-book-reader"></i> Lend Book
                </a>
                <a class="btn btn-app" href="?page=returnbook">
                  <i class="fas fa-book-dead"></i> Return Book
                </a>
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
<?php
}