<?php require_once 'assets/php/admin-header.php' ?>


<div class="row">
    <!-- <h1></?= basename($_SERVER['PHP_SELF']) ?></h1>  admin-deleteduser.php -->
    <div class="col-lg-12">
        <div class="card my-2 border-danger">
            <div class="card-header bg-danger text-white">
                <h4 class="m-0">Total Deleted Users</h4>
            </div>
            <div class="card-body">
                <div class="table-responsive" id="showAllDeletedUsers">
                    <p class="text-center align-self-center lead">Please Wait...</p>
                </div>
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

        // Fetch  All Deleted Users
        fetchAllDeletedUsers();

        function fetchAllDeletedUsers() {
            $.ajax({
                url: 'assets/php/admin-action.php',
                method: 'post',
                data: {
                    action: 'fetchAllDeletedUsers'
                },
                success: function(response) {
                    $("#showAllDeletedUsers").html(response);
                    $("table").DataTable({
                        order: [0, 'desc']
                    });
                }
            });
        }

        // Restore Deleted  User Ajax Request
        // restoreUserIcon class from a tag in admin-action.php
        $("body").on("click", ".restoreUserIcon", function(e) {
            e.preventDefault();
            res_id = $(this).attr('id');

            Swal.fire({
                title: 'Are you sure want restore this user?',
                type: 'warning',
                showCancelButton: true,
                confirmButtonColor: '#3085d6',
                cancelButtonColor: '#d33',
                confirmButtonText: 'Yes, restore it!'
            }).then((result) => {
                if (result.value) {
                    $.ajax({
                        url: 'assets/php/admin-action.php',
                        method: 'post',
                        data: {
                            res_id: res_id
                        },
                        success: function(response) {
                            //  console.log(response);
                            Swal.fire(
                                'Restored!',
                                'User restored successfully!',
                                'success'
                            )
                            fetchAllDeletedUsers();
                        }
                    });
                }
            })
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