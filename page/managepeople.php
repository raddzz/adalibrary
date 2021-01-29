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

  <title>Ada Library - Manage People</title>

  <!-- Font Awesome Icons -->
  <link rel="stylesheet" href="plugins/fontawesome-free/css/all.min.css">
  <!-- Theme style -->
  <link rel="stylesheet" href="dist/css/adminlte.min.css">
  <!-- Google Font: Source Sans Pro -->
  <link href="https://fonts.googleapis.com/css?family=Source+Sans+Pro:300,400,400i,700" rel="stylesheet">
  <link rel="stylesheet" type="text/css" href="plugins/datatables-bs4/css/dataTables.bootstrap4.css">
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
        <a href="/?page=managepeople" class="nav-link">Manage People</a>
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
          <li class="nav-item has-treeview menu-open">
            <a href="?page=management" class="nav-link active">
              <i class="nav-icon fas fa-cogs"></i>
              <p>
                Management
                <i class="right fas fa-angle-left"></i>
              </p>
            </a>
            <ul class="nav nav-treeview">
              <li class="nav-item">
                <a href="?page=people" class="nav-link active">
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
            <h1 class="m-0 text-dark">Manage People</h1>
          </div><!-- /.col -->
        </div><!-- /.row -->
      </div><!-- /.container-fluid -->
    </div>
    <!-- /.content-header -->

    <!-- Main content -->
    <div class="content">
      <div class="container-fluid">
        <div class="row">
          <div class="col-lg-12">
            <table class="table table-bordered table-hover" id="people"><thead><tr><th>First Name</th><th>Last Name</th><th>Email</th><th>More info</th><th>Auth</th></tr></thead><tbody>
            <?php

          $sql = "SELECT * FROM users where status = 'active'";
          $result = $conn->query($sql);

          if ($result->num_rows > 0) {
          // output data of each row
          while($row = $result->fetch_assoc()) {
          echo "<tr><td>".$row["firstname"]."</td><td>".$row["lastname"]."</td><td>".$row["email"]."</td><td><a href=?page=personinfo&userid=".$row["userid"].">Click here</a></td><td>".$row["authkey"]."</td></tr>";
          }
          } else {
          echo "0 results";
          }
          $conn->close();



            ?></tbody></table>
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
<!-- Datatable -->
<script src="plugins/datatables/jquery.dataTables.min.js"></script>
<script src="plugins/datatables-bs4/js/dataTables.bootstrap4.js"></script>
<script>
  $(function () {
    $('#people').DataTable({
      "paging": true,
      "lengthChange": false,
      "info": true,
      "autoWidth": false,
      "columnDefs": [
            {
                "targets": [ 4 ],
                "visible": false,
                "searchable": true
            },
        ]
    });
  });
</script>
</body>
</html>
