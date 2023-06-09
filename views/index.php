<?php
require_once __DIR__."/../views/sidebar.php";
require_once __DIR__."/../views/topBar.php";
require_once __DIR__."/../views/logoutModal.php";
require_once __DIR__."/../views/modalNotification.php";
?>

<!DOCTYPE html>
<html lang="en">

<head>

    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
    <meta name="description" content="">
    <meta name="author" content="">

    <title>Breukh school - HOME</title>

    <!-- Custom fonts for this template-->
    <link href="/views/vendor/fontawesome-free/css/all.min.css" rel="stylesheet" type="text/css">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css" integrity="sha512-iecdLmaskl7CVkqkXNQ/ZH/XLlvWZOJyj7Yy7tcenmpD1ypASozpmT/E0iPtmFIB46ZmdtAc9eNBvH0H/ZpiBw==" crossorigin="anonymous" referrerpolicy="no-referrer" />
    <!-- Custom styles for this template-->
    <link href="/views/css/sb-admin-2.css" rel="stylesheet">

</head>

<body id="page-top">

    <!-- Page Wrapper -->
    <div id="wrapper">

        <!-- Sidebar -->
       <?=$sideBar?>
        <!-- End of Sidebar -->

        <!-- Content Wrapper -->
        <div id="content-wrapper" class="d-flex flex-column">

            <!-- Main Content -->
            <div id="content">

                <!-- Topbar -->
                <?=$topBar?>
                <!-- End of Topbar -->

                <!-- Begin Page Content -->
                <div class="container-fluid">

                    <!-- Page Heading -->
                    <?=$content?>

                </div>
                <!-- /.container-fluid -->

            </div>
            <!-- End of Main Content -->


        </div>
        <!-- End of Content Wrapper -->

    </div>
    <!-- End of Page Wrapper -->

    <!-- Scroll to Top Button-->
    <a class="scroll-to-top rounded" href="#page-top">
        <i class="fas fa-angle-up"></i>
    </a>

    <!-- Logout Modal-->
    <?=$logoutModal?>

    <!-- notification Modal -->
    <?=$modalNotification?>

    <!-- Bootstrap core JavaScript-->
    <script src="/views/vendor/jquery/jquery.min.js"></script>
    <script src="/views/vendor/bootstrap/js/bootstrap.bundle.min.js"></script>
    <!-- typeahead core JavaScript -->
    <script src="https://cdnjs.cloudflare.com/ajax/libs/typeahead.js/0.11.1/typeahead.bundle.min.js" integrity="sha512-qOBWNAMfkz+vXXgbh0Wz7qYSLZp6c14R0bZeVX2TdQxWpuKr6yHjBIM69fcF8Ve4GUX6B6AKRQJqiiAmwvmUmQ==" crossorigin="anonymous" referrerpolicy="no-referrer"></script>
    
    <!-- Core plugin JavaScript-->
    <script src="/views/vendor/jquery-easing/jquery.easing.min.js"></script>

    <!-- Custom scripts for all pages-->
    <script src="/views/js/sb-admin-2.min.js"></script>


    <script src="/views/js/myscript.js" ></script>

    <!-- Page level plugins -->
    <script src="/views/vendor/chart.js"></script>

    <!-- Page level custom scripts -->
    <script src="/views/js/demo/chart-area-demo.js"></script>
    <script src="/views/js/demo/chart-pie-demo.js"></script>

</body>

</html>