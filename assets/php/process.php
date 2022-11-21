<?php

require_once 'session.php';

use PHPMailer\PHPMailer\PHPMailer;
use PHPMailer\PHPMailer\SMTP;
use PHPMailer\PHPMailer\Exception;

//Load Composer's autoloader
require 'vendor/autoload.php';

//Create an instance; passing `true` enables exceptions
$mail = new PHPMailer(true);

//Handle Add New Note Ajax Request
if (isset($_POST['action']) && $_POST['action'] == 'add_note') {
    // print_r($_POST);   // Array ( [title] => xexe  [note] => ddd  [action] => add_note )
    $title = $cuser->test_input($_POST['title']);
    $note = $cuser->test_input($_POST['note']);

    $cuser->add_new_note($cid, $title, $note);  // $cid is from session.php
    $cuser->notification($cid, 'admin', 'New Note added');
}

//Handle Display All Notes Of An User
if (isset($_POST['action']) && $_POST['action'] == 'display_notes') {
    $output = '';

    $notes = $cuser->get_notes($cid);

    // print_r($notes);

    if ($notes) {
        $output .= '<table class="table table-striped  text-center">
        <thead>
            <tr>
                <th>#</th>
                <th>Title</th>
                <th>Note</th>
                <th>Action</th>
            </tr>
        </thead>
        <tbody>';

        foreach ($notes as $row) {
            $output .= '<tr>
            <td>' . $row['id'] . '</td>
            <td>' . $row['title']   . '</td>
            <td>' . substr($row['note'], 0, 55) . '...</td>
            <td>
            
                <a href="#" id="' . $row['id'] . '"  title="View Details" class="text-success infoBtn"><i class="fas fa-info-circle fa-lg"></i></a>&nbsp;
                <a href="#" id="' . $row['id'] . '"  title="Edit Note" class="text-primary editBtn" data-toggle="modal" data-target="#editNoteModal"><i class="fas fa-edit fa-lg"></i></a>&nbsp;
                <a href="#" id="' . $row['id'] . '"  title="Delete Note" class="text-danger deleteBtn"><i class="fas fa-trash-alt fa-lg"></i></a>
            </td>
        </tr>';
        }
        $output .= '</tbody></table>';
        echo $output;
    } else {
        echo '<h3 class="text-center text-secondary">:( You have not written any note yet! Write your first note now!</h3>';
    }
}


// Hande Edit Note of An User Ajax Request
if (isset($_POST['edit_id'])) {
    // print_r($_POST);  //  Array ( key [edit_id] =>  value 9 )

    $id = $_POST['edit_id'];

    $row = $cuser->edit_note($id);
    echo json_encode($row);   // JSON format json_encode() is a native PHP function that allows you to convert PHP data into the JSON format.
    // JSON format {"id":12,"user_id":7,"title":"MySQL","note":"MySQL is a widely used relational database management system (RDBMS). MySQL is free and open-source. MySQL is ideal for both small and large applications.","created_at":"2022-11-15 13:38:08","updated_at":"2022-11-15 13:38:08"}
}



// Handle Update Note of An User Ajax Request
if (isset($_POST['action']) && $_POST['action'] == 'update_note') {
    //  print_r($_POST);
    $id = $cuser->test_input($_POST['id']);
    $title = $cuser->test_input($_POST['title']);
    $note = $cuser->test_input($_POST['note']);

    $cuser->update_note($id, $title, $note);
    $cuser->notification($cid, 'admin', 'Note updated');
}

// Handle Delete Note of AN User Ajax Request
if (isset($_POST['del_id'])) {
    $id = $_POST['del_id'];


    $cuser->delete_note($id);
    $cuser->notification($cid, 'admin', 'Note deleted');
}


// Handle Display a Note of An User Ajax Request
if (isset($_POST['info_note_id'])) {
    $id = $_POST['info_note_id'];

    $row = $cuser->edit_note($id);

    echo json_encode($row);   // JSON FORMAT
}


//************************************* PROFILE SECTION  PAGE ************************************ */

// Handle Profile Update Ajax Request
if (isset($_FILES['image'])) {
    // print_r($_FILES); // all properties of image
    // print_r($_POST);  // 2 arrays info about image and another input fields data
    $name = $cuser->test_input($_POST['name']);
    $gender = $cuser->test_input($_POST['gender']);
    $dob = $cuser->test_input($_POST['dob']);
    $phone = $cuser->test_input($_POST['phone']);

    $oldImage = $_POST['oldImage'];
    $folder = 'uploads/';

    if (isset($_FILES['image']['name']) && ($_FILES['image']['name'] != "")) {
        $newImage = $folder . $_FILES['image']['name']; // path of uploaded image
        move_uploaded_file($_FILES['image']['tmp_name'], $newImage);

        if ($oldImage != null) {
            unlink($oldImage);
        }
    } else {
        $newImage = $oldImage;
    }
    $cuser->update_profile($name, $gender, $dob, $phone, $newImage, $cid);
    $cuser->notification($cid, 'admin', 'Profile updated');
}

// Hande Change Password Ajax Request
if (isset($_POST['action']) && $_POST['action'] == 'change_pass') {
    //  print_r($_POST); // [curpass] => 1232dadas [newpass] => 12345 [cnewpass] => 12345 [action] => change_pass
    $currentPass = $_POST['curpass'];

    $newPass = $_POST['newpass'];
    $cnewPass = $_POST['cnewpass'];

    $hnewPass =  password_hash($newPass, PASSWORD_DEFAULT);

    if ($newPass != $cnewPass) {
        echo $cuser->showMessage('danger', 'Password did not matched!');
    } else {
        if (password_verify($currentPass, $cpass)) {
            $cuser->change_password($hnewPass, $cid);
            echo $cuser->showMessage('success', 'Password Changed Successfully!');
            $cuser->notification($cid, 'admin', 'Passowrd change!');
        } else {
            echo $cuser->showMessage('danger', 'Current Password is Wrong!');
        }
    }
}

// Hande Verify E-Mail Ajax Request
if (isset($_POST['action']) && $_POST['action'] == 'verify_email') {
    try {
        $mail->isSMTP();
        $mail->Host = 'smtp.gmail.com';
        $mail->SMTPAuth =  true;
        $mail->Username = Database::USERNAME;
        $mail->Password = Database::PASSWORD;
        // $mail->Password = 'taixffwsdcugkybp';
        $mail->SMTPSecure =  PHPMailer::ENCRYPTION_STARTTLS;
        $mail->Port = 587;

        $mail->setFrom(Database::USERNAME, 'Blex Web Programming');
        $mail->addAddress($cemail);

        //Content
        $mail->isHTML(true);
        $mail->Subject = 'E-Mail Verification';
        $mail->Body = '<h3>Click the below link to verify your E-Mail.<br>
        <a href="http://localhost/blexOfWeb2PDOoop/user-system/verify-email.php?email=' . $cemail . '">
        http://localhost/blexOfWeb2PDOoop/user-system/verify-email.php?email=' . $cemail . '</a><br>Regards<br>Blex!</h3>';

        $mail->send();
        echo $cuser->showMessage('success', 'Verification link sent to your E-Mail. Please check your mail!');
    } catch (Exception $e) {
        echo $cuser->showMessage('danger', 'Something went wrong please try again later!');
        // echo $user->$e;
    }
}


//********************* FEEDBACK  PAGE**************************/

// Handle Send Feedback to Admin Ajax Request
if (isset($_POST['action']) && $_POST['action'] == 'feedback') {
    // print_r($_POST);  //// [subject] => ddd [feedback] => aaa [action] => feedback
    $subject = $cuser->test_input($_POST['subject']);
    $feedback = $cuser->test_input($_POST['feedback']);

    $cuser->send_feedback($subject, $feedback, $cid);
    $cuser->notification($cid, 'admin', 'Feedback written');
}

//********************* NOTIFICATION  PAGE **************************/

// Handle Fetch Notification
if (isset($_POST['action']) && $_POST['action'] == 'fetchNotification') {
    $notification = $cuser->fetchNotification($cid);
    $output = '';

    if ($notification) {
        foreach ($notification as $row) {
            $output .= ' <div class="alert alert-danger" role="alert">
            <button type="button" id="' . $row['id'] . '" class="close" data-dismiss="alert" aria-label="Close">
                <span aria-hidden="true">&times;</span>
            </button>
         
            <h4 class="alert-heading">New Notification</h4>
            <p class="mb-0 lead">' . $row['message'] . '</p>
            <hr class="my-2">
            <p class="mb-0 float-left">Replay of feedback from Admin</p>
            <p class="mb-0 float-right">' . $cuser->timeInAgo($row['created_at']) . '</p>
            <div class="clearfix"></div>
        </div>';
        }
        echo $output;
    } else {
        echo '<h3 class="text-center text-secondary nt-5">No any new notification</h3>';
    }
}

// Check Notification
if (isset($_POST['action']) && $_POST['action'] == 'checkNotification') {
    if ($cuser->fetchNotification($cid)) {
        echo '<i class="fas fa-circle  fa-sm text-danger"></i>';
    } else {
        echo '';
    }
}

// Remove Notification
if (isset($_POST['notification_id'])) {
    $id =  $_POST['notification_id'];
    $cuser->removeNotification($id);
}
