<?php require_once 'assets/php/admin-header.php' ?>


<div class="row">
    <!-- <h1><//?= basename($_SERVER['PHP_SELF']) ?></h1> admin-feedback.php -->
    <div class="col-lg-12">
        <div class="card my-2 border-warning">
            <div class="card-header bg-warning text-white">
                <h4 class="m-0">Total Feedback From Users</h4>
            </div>
            <div class="card-body">
                <div class="table-responsive" id="showAllFeedback">
                    <p class="text-center align-self-center lead">Please Wait...</p>
                </div>
            </div>
        </div>
    </div>
</div>

<!-- Reply Feedback Modal -->
<div class="modal fade" id="showReplyModal">
    <div class="modal-dialog modal-dialog-centered">
        <div class="modal-content">
            <div class="modal-header">
                <h4 class="modal-title">Reply This Feedback</h4>
                <button type="button" class="close" data-dismiss="modal">&times;</button>
            </div>
            <div class="modal-body">
                <form action="#" method="post" class="px-3" id="feedback-replay-form">
                    <div class="from-group">
                        <textarea name="message" id="message" rows="6" class="form-control" placeholder="Write Your Message Here..." required></textarea>
                        <div class="form-group">
                            <input type="submit" name="submit" value="Send Reply" class="btn btn-primary btn-block" id="feedbackReplyBtn"></input>
                        </div>
                    </div>
                </form>
            </div>
        </div>
    </div>
</div>

<!-- Footer Area -->
</div>
</div>
</div>
<script type="text/javascript" src="https://cdn.datatables.net/v/bs4/dt-1.13.1/datatables.min.js"></script>
<script src="https://cdn.jsdelivr.net/npm/sweetalert2@8"></script>
<script>
    $(document).ready(function() {

        // Fetch All Feedback of Users Ajax Request
        fetchAllFeedback();

        function fetchAllFeedback() {
            $.ajax({
                url: 'assets/php/admin-action.php',
                method: 'post',
                data: {
                    action: 'fetchAllFeedback'
                },
                success: function(response) {
                    $("#showAllFeedback").html(response);
                    $("table").DataTable({
                        order: [0, 'desc']
                    });
                }
            });
        }

        // Get The Current Row User Id and Feedback ID
        // replayFeedbackIcon class from a tag in admin-action.php
        var user_id;
        var feedback_id;
        $("body").on("click", ".replayFeedbackIcon", function(e) {
            user_id = $(this).attr('id');
            feedback_id = $(this).attr('fid');
            // console.log(user_id);
            // console.log(feedback_id);
        });

        //FORM Send Feedback Reply to the User Ajax Request
        $('#feedbackReplyBtn').click(function(e) {
            if ($("#feedback-replay-form")[0].checkValidity()) {
                let message = $("#message").val(); // grabbing value from text area by id
                e.preventDefault();
                $('#feedbackReplyBtn').val('Please Wait...');

                $.ajax({
                    url: 'assets/php/admin-action.php',
                    method: 'post',
                    data: {
                        user_id: user_id,
                        message: message,
                        feedback_id: feedback_id
                    },
                    success: function(response) {
                        // console.log(response);
                        $("#feedbackReplyBtn").val('Send Reply');
                        $("#showReplyModal").modal('hide');
                        $("#feedback-replay-form")[0].reset();
                        Swal.fire(
                            'Sent!',
                            'Reply sent successfully to the user!',
                            'success'
                        )
                        fetchAllFeedback();
                    }
                });
            }
        });


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

    });
</script>



</body>

</html>