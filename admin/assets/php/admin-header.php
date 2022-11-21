<?php
session_start();
if (!isset($_SESSION['username'])) {
    header('Location: index.php');
    exit();
}
?>
<!-- <a href="assets/php/logout.php">Logout</a> -->

<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="author" content="Branko Blesic">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="../assets/css/bootstrap.min.css">
    <link rel="stylesheet" href="assets/css/style.css">
    <script src="../assets/js/jquery.min.js"></script>
    <script src="../assets/js/bootstrap.bundle.min.js"></script>
    <script src="../assets/js/all.min.js" defer></script>
    <script>
        $(document).ready(function() {
            $("#open-nav").click(function() {
                $(".admin-nav").toggleClass('animate');
            });
        });
    </script>
    <?php
    $title  = basename($_SERVER['PHP_SELF'], '.php');
    //echo $title; // admin-dashboard

    $title = explode('-', $title); // return array of string
    // print_r($title);  // Array ( [0] => admin [1] => dashboard )

    $title = ucfirst($title[1]);
    //print_r($title); // Dashboard
    ?>
    <title><?= $title; ?> | Admin Panel</title>
    <link rel="stylesheet" type="text/css" href="https://cdn.datatables.net/v/bs4/dt-1.13.1/datatables.min.css" />

    <style>
        .admin-nav {
            width: 200px;
            min-height: 100vh;
            overflow: hidden;
            background-color: #343a40;
            transition: 0.3s all ease-in-out;
        }

        .admin-link {
            background-color: #343a40;
        }

        .admin-link:hover,
        .nav-active {
            background-color: #212529;
            text-decoration: none;
        }

        .animate {
            width: 0;
            transition: 0.3s all ease-in-out;
        }
    </style>
</head>

<body>
    <div class="container-fluid">
        <div class="row">
            <div class="admin-nav p-0">
                <h4 class="text-light text-center p-2">Admin Panel</h4>
                <div class="list-group list-group-flush">
                    <a href="admin-dashboard.php" class="list-group-item text-light admin-link <?= (basename($_SERVER['PHP_SELF']) == 'admin-dashboard.php') ? "nav-active" : ""; ?> ">
                        <i class="fas fa-chart-pie"></i>&nbsp;&nbsp;Dashboard</a>

                    <a href="admin-users.php" class="list-group-item text-light admin-link  <?= (basename($_SERVER['PHP_SELF']) == 'admin-users.php') ? "nav-active" : ""; ?> ">
                        <i class="fas fa-user-friends"></i>&nbsp;&nbsp;Users</a>

                    <a href="admin-notes.php" class="list-group-item text-light admin-link  <?= (basename($_SERVER['PHP_SELF']) == 'admin-notes.php') ? "nav-active" : ""; ?> ">
                        <i class="fas fa-sticky-note"></i>&nbsp;&nbsp;Notes</a>

                    <a href="admin-feedback.php" class="list-group-item text-light admin-link <?= (basename($_SERVER['PHP_SELF']) == 'admin-feedback.php') ? "nav-active" : ""; ?> ">
                        <i class="fas fa-comment"></i>&nbsp;&nbsp;Feedback</a>

                    <a href="admin-notification.php" class="list-group-item text-light admin-link <?= (basename($_SERVER['PHP_SELF']) == 'admin-notification.php') ? "nav-active" : ""; ?>">
                        <i class="fas fa-bell"></i>&nbsp;&nbsp;Notification &nbsp; <span id="checkNotification"></span> </a>

                    <a href="admin-deleteduser.php" class="list-group-item text-light admin-link <?= (basename($_SERVER['PHP_SELF']) == 'admin-deleteduser.php') ? "nav-active" : ""; ?>">
                        <i class="fas fa-user-slash"></i>&nbsp;&nbsp;Deleted Users</a>

                    <a href="assets/php/admin-action.php?export=excel" class="list-group-item text-light admin-link"> <i class="fas fa-table"></i>&nbsp;&nbsp;Export Users</a>

                    <a href="#" class="list-group-item text-light admin-link"> <i class="fas fa-id-card"></i>&nbsp;&nbsp;Profile</a>

                    <a href="#" class="list-group-item text-light admin-link"> <i class="fas fa-cog"></i>&nbsp;&nbsp;Settings</a>
                </div>
            </div>
            <div class="col">
                <div class="row">
                    <div class="col-lg-12 bg-primary pt-2 justify-content-between d-flex">
                        <a href="#" class="text-white" id="open-nav">
                            <h3><i class="fas fa-bars"></i></h3>
                        </a>

                        <h4 class="text-light"><?php echo $title; ?></h4>

                        <a href="assets/php/logout.php" class="text-light mt-1"><i class="fas fa-sign-out-alt"></i>&nbsp;Logout</a>
                    </div>
                </div>