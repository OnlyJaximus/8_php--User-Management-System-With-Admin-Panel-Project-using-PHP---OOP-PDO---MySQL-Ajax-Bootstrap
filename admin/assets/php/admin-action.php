
<?php
session_start();
require_once 'admin-db.php';
$admin = new Admin();

// Handdle Admin Login Ajax Request
if (isset($_POST['action']) && $_POST['action'] == 'adminLogin') {
    // print_r($_POST);  // Array (  [username] => Bleki [password] => 123 [action] => adminLogin )

    $username = $admin->test_input($_POST['username']);
    $password  = $admin->test_input($_POST['password']);

    $hpassword = sha1($password);  // The sha1() function calculates the SHA-1 hash of a string. The sha1() function uses the US Secure Hash Algorithm 1.

    $loggedInAdmin = $admin->admin_login($username, $hpassword);

    if ($loggedInAdmin != null) {
        echo 'admin_login';
        $_SESSION['username'] = $username;
    } else {
        echo $admin->showMessage('danger', 'Username or Password is Incorrect!');
    }
}

//Handle Fetch All Users Ajax Request
if (isset($_POST['action']) && $_POST['action'] == 'fetchAllUsers') {
    // echo "Working";
    $output = '';
    $data = $admin->fetchAllUsers(0);
    $path = '../assets/php/';


    if ($data) {
        $output .= '<table class="table table-striped table-bordered text-center">
                        <thead>
                            <tr>
                                <th>#</th>
                                <th>Image</th>
                                <th>Name</th>
                                <th>E-Mail</th>
                                <th>Phone</th>
                                <th>Gender</th>
                                <th>Verified</th>
                                <th>Action</th>
                            </tr>
                        </thead>
                        <tbody>';
        foreach ($data as $row) {
            if ($row['photo'] != '') {
                $uphoto =  $path . $row['photo'];
            } else {
                $uphoto = '../assets/img/avatar.jpg';
            }
            $output .= '<tr>
                            <td>' . $row['id'] . '</td>
                            <td><img src="' . $uphoto . '" class="rounded-circle" width="40px"></td>
                            <td>' . $row['name'] . '</td>
                            <td>' . $row['email'] . '</td>
                            <td>' . $row['phone'] . '</td>
                            <td>' . $row['gender'] . '</td>
                            <td>' . $row['verified'] . '</td>
                            <td>
                                <a href="#" id="' . $row['id'] . '" title="View Details" class="text-primary userDetailsIcon" data-toggle="modal" data-target="#showUserDetailsModal"><i class="fas fa-info-circle fa-lg"></i></a>&nbsp;&nbsp;
                                <a href="#" id="' . $row['id'] . '" title="Delete User" class="text-danger deleteUserIcon"><i class="fas fa-trash-alt fa-lg"></i></a>&nbsp;&nbsp;
                            </td>
                            </tr>';
        }

        $output .= '         
                      </tbody>
                  </table>';
        echo $output;
    } else {
        echo '<h3 class="text-center text-secondary">:( No any user registered yet</h3>';
    }
}

// Handle Display User In Details Ajax Request
if (isset($_POST['details_id'])) {
    $id =  $_POST['details_id'];

    $data = $admin->fetchUserDetailsByID($id);

    echo json_encode($data);
}

// Handle Delete an User Ajax Request
if (isset($_POST['del_id'])) {
    $id = $_POST['del_id'];

    $admin->userAction($id, 0);
}


// ********************* DELETED USERS ********************************

// Handle Fetch All Deleted Users Ajax Request

if (isset($_POST['action']) && $_POST['action'] == 'fetchAllDeletedUsers') {
    // echo "Working";
    $output = '';
    $data = $admin->fetchAllUsers(1);
    $path = '../assets/php/';


    if ($data) {
        $output .= '<table class="table table-striped table-bordered text-center">
                        <thead>
                            <tr>
                                <th>#</th>
                                <th>Image</th>
                                <th>Name</th>
                                <th>E-Mail</th>
                                <th>Phone</th>
                                <th>Gender</th>
                                <th>Verified</th>
                                <th>Action</th>
                            </tr>
                        </thead>
                        <tbody>';
        foreach ($data as $row) {
            if ($row['photo'] != '') {
                $uphoto =  $path . $row['photo'];
            } else {
                $uphoto = '../assets/img/avatar.jpg';
            }
            $output .= '<tr>
                            <td>' . $row['id'] . '</td>
                            <td><img src="' . $uphoto . '" class="rounded-circle" width="40px"></td>
                            <td>' . $row['name'] . '</td>
                            <td>' . $row['email'] . '</td>
                            <td>' . $row['phone'] . '</td>
                            <td>' . $row['gender'] . '</td>
                            <td>' . $row['verified'] . '</td>
                            <td>
                             
                                
                                <a href="#" id="' . $row['id'] . '" title="Restore User" class="text-white restoreUserIcon badge badge-dark p-2">Restore</a>
                            </td>
                            </tr>';
        }

        $output .= '         
                      </tbody>
                  </table>';
        echo $output;
    } else {
        echo '<h3 class="text-center text-secondary">:( No any user deleted yet</h3>';
    }
}

// Handle Restore Deleted User Ajax Request
if (isset($_POST['res_id'])) {
    $user_id = $_POST['res_id'];
    // print_r($user_id);

    $admin->userAction($user_id, 1);
}

// Handle Fetch All Notes Ajax Request
if (isset($_POST['action']) && $_POST['action'] == 'fetchAllNotes') {
    // echo "Working";
    $output = '';
    $note = $admin->fetchAllNotes();



    if ($note) {
        $output .= '<table class="table table-striped table-bordered text-center">
                        <thead>
                            <tr>
                                <th>#</th>
                                <th>User Name</th>
                                <th>User E-Mail</th>
                                <th>Note Title</th>
                                <th>Notee</th>
                                <th>Written On</th>
                                <th>Updated On</th>
                                <th>Action</th>
                            </tr>
                        </thead>
                        <tbody>';
        foreach ($note as $row) {

            $output .= '<tr>
                            <td>' . $row['id'] . '</td>
                            <td>' . $row['name'] . '</td>
                            <td>' . $row['email'] . '</td>
                            <td>' . $row['title'] . '</td>
                            <td>' . $row['note'] . '</td>
                            <td>' . $row['created_at'] . '</td>
                            <td>' . $row['updated_at'] . '</td>
                            <td>
                             
                                
                                <a href="#" id="' . $row['id'] . '" title="Delete Note" class="text-danger deleteNoteIcon" data-toggle="modal" data-target="#showUserDetailsModal" ><i class="fas fa-trash fa-lg"></i></a>
                            </td>
                            </tr>';
        }

        $output .= '         
                      </tbody>
                  </table>';
        echo $output;
    } else {
        echo '<h3 class="text-center text-secondary">:( No any notes written</h3>';
    }
}


// Handle Delete Note of An User Ajax Request
if (isset($_POST['note_id'])) {
    $id = $_POST['note_id'];
    //print_r($id);
    $admin->deleteNote($id);
}

// Handle Fetch All Feedback Users Ajax Request
if (isset($_POST['action']) && $_POST['action'] == 'fetchAllFeedback') {
    // echo "Working";
    $output = '';
    $feedback = $admin->fetchFeedback();



    if ($feedback) {
        $output .= '<table class="table table-striped table-bordered text-center">
                        <thead>
                            <tr>
                                <th>FID</th>
                                <th>UID</th>
                                <th>User Name</th>
                                <th>User E-Mail</th>
                                <th>Subject</th>
                                <th>Feedback</th>
                                <th>Sent On</th>
                                <th>Action</th>
                            </tr>
                        </thead>
                        <tbody>';
        foreach ($feedback as $row) {

            $output .= '<tr>
                            <td>' . $row['id'] . '</td>
                            <td>' . $row['user_id'] . '</td>
                            <td>' . $row['name'] . '</td>
                            <td>' . $row['email'] . '</td>
                            <td>' . $row['subject'] . '</td>
                            <td>' . $row['feedback'] . '</td>
                            <td>' . $row['created_at'] . '</td>
                            <td>
                                <a href="#"  fid="' . $row['id'] . '"  id="' . $row['user_id'] . '" title="Replay" class="text-primary replayFeedbackIcon"  data-toggle="modal" data-target="#showReplyModal"><i class="fas fa-reply fa-lg"></i></a>
                            </td>
                            </tr>';
        }

        $output .= '         
                      </tbody>
                  </table>';
        echo $output;
    } else {
        echo '<h3 class="text-center text-secondary">:( No any feedback written</h3>';
    }
}

// Handle Reply Feedback to User Ajax Request
if (isset($_POST['message'])) {
    // print_r($_POST);  // Array( [user_id] => 7 [message] => xexexe )
    $user_id = $_POST['user_id'];
    $message = $admin->test_input($_POST['message']);
    $feedback_id = $_POST['feedback_id'];

    $admin->replyFeedback($user_id, $message);
    $admin->feeddbackReplied($feedback_id);
}


// *************** ADMIN NOTIFICATION **********************
// Handle Fetch Notification Ajax Request
if (isset($_POST['action']) && $_POST['action'] == 'fetchNotification') {
    $notification = $admin->fetchNotification();
    $output = '';

    if ($notification) {
        foreach ($notification as $row) {
            $output .= ' <div class="alert alert-dark" role="alert">
            <button type="button" id="' . $row['id'] . '" class="close" data-dismiss="alert" aria-label="Close">
                <span aria-hidden="true">&times;</span>
            </button>
         
            <h4 class="alert-heading">New Notification</h4>
            <p class="mb-0 lead">' . $row['message'] . '  by ' . $row['name'] . '</p>
            <hr class="my-2">
            <p class="mb-0 float-left"><b>User E-Mail :<b> ' . $row['email'] . '</p>
            <p class="mb-0 float-right">' . $admin->timeInAgo($row['created_at']) . '</p>
            <div class="clearfix"></div>
        </div>';
        }
        echo $output;
    } else {
        echo '<h3 class="text-center text-secondary nt-5">No any new notification</h3>';
    }
}

// Handle Check Notification for red circle
if (isset($_POST['action']) && $_POST['action'] == 'checkNotification') {
    if ($admin->fetchNotification()) {
        echo '<i class="fas fa-circle text-danger fa-sm"></i>';
    } else {
        echo '';
    }
}

// Handle Remove Notification
if (isset($_POST['notification_id'])) {
    $id =  $_POST['notification_id'];

    $admin->removeNotification($id);
}

// Handle Export All Users in Excel
if (isset($_GET['export']) && $_GET['export'] == 'excel') {
    header("Content-Type: application/xls");
    header("Content-Disposition: attachment; filename=users.xls");
    header("Pragma: no-cache");
    header("Expires: 0");

    $data = $admin->exportAllUsers();
    echo '<table border="1" align=center>';
    echo '<tr>
             <th>#</th>
             <th>Name</th>
             <th>E-Mail</th>
             <th>Phone</th>
             <th>Gender</th>
             <th>DOB</th>
             <th>Joined ON</th>
             <th>Verified</th>
             <th>Deleted</th>
          </tr>';

    foreach ($data as $row) {
        echo '<tr>
                    <td>' . $row['id'] . '</td>
                    <td>' . $row['name'] . '</td>
                    <td>' . $row['email'] . '</td>
                    <td>' . $row['phone'] . '</td>
                    <td>' . $row['gender'] . '</td>
                    <td>' . $row['dob'] . '</td>
                    <td>' . $row['verified'] . '</td>
                    <td>' . $row['deleted'] . '</td>    
                 </tr>';
    }
    echo '</table>';
}
