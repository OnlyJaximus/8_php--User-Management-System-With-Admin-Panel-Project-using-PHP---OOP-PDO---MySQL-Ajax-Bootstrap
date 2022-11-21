<?php require_once 'assets/php/admin-header.php' ?>


<div class="row">
    <!-- <h1><//?= basename($_SERVER['PHP_SELF']) ?></h1>  admin-notes.php-->
    <div class="col-lg-12">
        <div class="card my-2 border-secondary">
            <div class="card-header bg-secondary text-white">
                <h4 class="m-0">Total Notes By All Users</h4>
            </div>
            <div class="card-body">
                <div class="table-responsive" id="showAllNotes">
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
        // Fetch All Notes Ajax Request
        fetchAllNotes();

        function fetchAllNotes() {
            $.ajax({
                url: 'assets/php/admin-action.php',
                method: 'post',
                data: {
                    action: 'fetchAllNotes'
                },
                success: function(response) {
                    // console.log(response);
                    $("#showAllNotes").html(response);
                    $('table').DataTable({
                        order: [0, 'desc'],
                    });
                }
            });
        }


        // Delete Note Ajax Request
        // deleteNoteIcon from admin-action.php a tag
        $("body").on("click", ".deleteNoteIcon", function(e) {
            e.preventDefault();
            note_id = $(this).attr('id');

            Swal.fire({
                title: 'Are you sure?',
                text: "You won't be able to revert this!",
                type: 'warning',
                showCancelButton: true,
                confirmButtonColor: '#3085d6',
                cancelButtonColor: '#d33',
                confirmButtonText: 'Yes, delete it!'
            }).then((result) => {
                if (result.value) {
                    $.ajax({
                        url: 'assets/php/admin-action.php',
                        method: 'post',
                        data: {
                            note_id: note_id
                        },
                        success: function(response) {
                            console.log(response);
                            Swal.fire(
                                'Deleted!',
                                'Note deleted successfully!',
                                'success'
                            )
                            fetchAllNotes();
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