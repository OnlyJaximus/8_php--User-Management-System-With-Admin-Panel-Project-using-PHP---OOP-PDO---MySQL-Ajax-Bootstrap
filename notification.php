<?php require_once('assets/php/header.php') ?>
<!-- <h1><//?= basename($_SERVER['PHP_SELF']); ?></h1>  notification.php -->

<div class="container">
    <div class="row justify-content-center my-2">
        <div class="col-lg-6 mt-4" id="showAllNotification">

        </div>
    </div>
</div>

<script src="assets/js/jquery.min.js"></script>
<script src="assets/js/bootstrap.bundle.min.js"></script>
<script src="assets/js/all.min.js"></script>

<script>
    $(document).ready(function() {




        // Fetch Notification of an User function (view notifications)
        fetchNotification();

        function fetchNotification() {
            $.ajax({
                url: 'assets/php/process.php',
                method: 'post',
                data: {
                    action: 'fetchNotification'
                },
                success: function(response) {
                    //console.log(response);
                    $("#showAllNotification").html(response);
                }
            });
        }



        // Check Notification function (navbar red circle)
        checkNotification();

        function checkNotification() {
            $.ajax({
                url: 'assets/php/process.php',
                method: 'post',
                data: {
                    action: 'checkNotification'
                },
                success: function(response) {
                    //  console.log(response); // <i class="fas fa-circle  fa-sm text-danger"></i>  = red circle next to the Notification navbar icon
                    $("#checkNotification").html(response);
                }
            });
        }

        //Remove Notification
        $("body").on("click", ".close", function(e) {
            e.preventDefault();

            notification_id = $(this).attr('id');

            $.ajax({
                url: 'assets/php/process.php',
                method: 'post',
                data: {
                    notification_id: notification_id
                },
                success: function(response) {
                    checkNotification();
                    fetchNotification();
                }
            });
        });

    });
</script>

</body>

</html>