<?php require_once 'assets/php/admin-header.php' ?>


<div class="row justify-content-center my-2">
    <!-- <h1><//?= basename($_SERVER['PHP_SELF']) ?></h1>  admin-notification.php -->
    <div class="col-lg-6 mt-4" id="showNotification">

    </div>
</div>

<!-- Footer Area -->
</div>
</div>
</div>
<script>
    $(document).ready(function() {

        //Fetch Notification Ajax Request
        fetchNotification();

        function fetchNotification() {
            $.ajax({
                url: 'assets/php/admin-action.php',
                method: 'post',
                data: {
                    action: 'fetchNotification'
                },
                success: function(response) {
                    // console.log(response);
                    $("#showNotification").html(response);
                }
            });
        }

        // Check Notification for red circle
        checkNotification();

        function checkNotification() {
            $.ajax({
                url: 'assets/php/admin-action.php',
                method: 'post',
                data: {
                    action: 'checkNotification'
                },
                success: function(response) {
                    console.log(response); // <i class="fasa fa-circle text-danger fa-sm"></i>
                    $("#checkNotification").html(response);
                }

            });
        }

        // Remove Notification Ajax Request
        // close -> class from admin-action
        $("body").on("click", ".close", function(e) {
            e.preventDefault();

            notification_id = $(this).attr('id'); // # from admin-action 

            $.ajax({
                url: 'assets/php/admin-action.php',
                method: 'post',
                data: {
                    notification_id: notification_id
                },
                success: function(response) {
                    fetchNotification();
                    checkNotification();
                }
            });
        });

    });
</script>

</body>

</html>