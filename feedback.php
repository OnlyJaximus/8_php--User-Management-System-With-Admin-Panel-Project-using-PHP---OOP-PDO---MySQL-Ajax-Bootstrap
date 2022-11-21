<?php require_once('assets/php/header.php') ?>

<!-- <h1><//?= basename($_SERVER['PHP_SELF']); ?></h1>  feedback.php-->

<div class="container">
    <div class="row justify-content-center">
        <div class="col-lg-8 mt-3">
            <?php if ($verified == 'Verified!') : ?>
                <div class="card border-primary">
                    <div class="card-header lead text-center bg-primary text-white">Send Feedback to Admin!</div>
                    <div class="card-body">
                        <form action="#" method="POST" class="px-4" id="feedback-form">
                            <div class="form-group">
                                <input type="text" name="subject" placeholder="Write Your Subject" class="form-control-lg form-control rounded-0" required>
                            </div>
                            <div class="form-group">
                                <textarea name="feedback" rows="8" class="form-control-lg form-control rounded-0" placeholder="Write Your Feedback Here..." required></textarea>
                            </div>

                            <div class="form-group">
                                <input type="submit" name="feedbackBtn" id="feedbackBtn" class="btn btn-primary btn-block btn-lg rounded-0" value="Send Feedback">
                            </div>
                        </form>
                    </div>
                </div>
            <?php else : ?>
                <h1 class="text-center text-secondary mt-5">Verify Your E-Mail First to Send Feedback to Admin!</h1>
            <?php endif; ?>
        </div>
    </div>
</div>


<script src="assets/js/jquery.min.js"></script>
<script src="assets/js/bootstrap.bundle.min.js"></script>
<script src="assets/js/all.min.js"></script>
<script src="https://cdn.jsdelivr.net/npm/sweetalert2@8"></script>
<script>
    $(document).ready(function() {

        // Send Feedback to Admin Ajax Requst
        $("#feedbackBtn").click(function(e) {
            if ($("#feedback-form")[0].checkValidity()) {
                e.preventDefault();
                $(this).val('Please Wait...');

                $.ajax({
                    url: 'assets/php/process.php',
                    method: 'post',
                    data: $("#feedback-form").serialize() + "&action=feedback",
                    success: function(response) {
                        // console.log(response); // [subject] => ddd [feedback] => aaa [action] => feedback
                        $("#feedback-form")[0].reset();
                        $(this).val('Send Feedback');
                        $("#feedbackBtn").val('Send Feedback');
                        Swal.fire({
                            title: 'Feedback Successfully sent to Admin!',
                            type: 'success'

                        });
                    }
                });
            }
        });

        // Check Notification function for red circle
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
    });
</script>

</body>

</html>