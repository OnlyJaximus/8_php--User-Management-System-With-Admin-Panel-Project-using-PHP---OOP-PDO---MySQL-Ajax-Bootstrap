<?php
require_once('config.php');

class Auth extends Database
{
    //Register New User
    public function register($name, $email, $password)
    {
        $sql = "INSERT INTO users (name, email, password) VALUES (:name, :email, :pass)";
        $stmt = $this->conn->prepare($sql);
        $stmt->execute(['name' => $name, 'email' => $email, 'pass' => $password]);
        return true;
    }

    //Check if user already registered
    public function user_exists($email)
    {
        $sql = "SELECT email FROM  users WHERE email = :email";
        $stmt = $this->conn->prepare($sql);
        $stmt->execute(['email' => $email]);
        $result = $stmt->fetch(PDO::FETCH_ASSOC);
        return $result;
    }

    //Login Existing User
    public function login($email)
    {
        $sql = "SELECT email, password FROM users WHERE email = :email AND deleted != 0";
        $stmt = $this->conn->prepare($sql);
        $stmt->execute(['email' => $email]);
        $row =  $stmt->fetch(PDO::FETCH_ASSOC);

        return $row;
    }

    //Current User In Session
    public function currentUser($email)
    {
        $sql = "SELECT * FROM users where email = :email AND deleted != 0";
        $stmt = $this->conn->prepare($sql);
        $stmt->execute(['email' => $email]);
        $row = $stmt->fetch(PDO::FETCH_ASSOC);

        return $row;
    }

    // Forgot Password Index.php
    public function forgot_password($token, $email)
    {
        $sql = "UPDATE users SET token = :token, token_expire =  DATE_ADD(NOW(), INTERVAL 10 MINUTE) WHERE email=:email";
        $stmt = $this->conn->prepare($sql);
        $stmt->execute(['token' => $token, 'email' => $email]);

        return true;
    }

    // Reset Password User Auth reset-passs.php
    public function reset_pass_auth($email, $token)
    {
        $sql = "SELECT id FROM users WHERE email =:email AND token = :token AND token != '' AND token_expire > NOW() AND deleted != 0";
        $stmt = $this->conn->prepare($sql);
        $stmt->execute(['email' => $email, 'token' => $token]);

        $row = $stmt->fetch(PDO::FETCH_ASSOC);

        return $row;
    }

    // Update New Password
    public function update_new_pas($pass, $email)
    {
        $sql = "UPDATE users SET token = '', password=:pass WHERE email = :email AND deleted != 0";
        $stmt = $this->conn->prepare($sql);
        $stmt->execute(['pass' => $pass, 'email' => $email]);
        return true;
    }

    //***************************** NOTE ********************************************* */

    // Add New Note
    public function add_new_note($user_id, $title, $note)
    {
        $sql = "INSERT INTO notes (user_id, title, note) VALUE (:user_id, :title, :note)";
        $stmt = $this->conn->prepare($sql);
        $stmt->execute(['user_id' => $user_id, 'title' => $title, 'note' => $note]);
        return true;
    }

    // Fetch All Note Of An User
    public function get_notes($user_id)
    {
        $sql = "SELECT * FROM notes where user_id = :user_id";
        $stmt = $this->conn->prepare($sql);
        $stmt->execute(['user_id' => $user_id]);

        $result =  $stmt->fetchAll(PDO::FETCH_ASSOC);
        return $result;
    }


    // Edit Note of An User
    public function edit_note($id)
    {
        $sql = "SELECT * FROM NOTES WHERE id =:id";
        $stmt = $this->conn->prepare($sql);
        $stmt->execute(['id' => $id]);

        $result = $stmt->fetch(PDO::FETCH_ASSOC);

        return $result;
    }


    // Update Note of An User
    public function update_note($id, $title, $note)
    {
        $sql = "UPDATE notes SET title=:title, note=:note, updated_at = now() WHERE id=:id";
        $stmt = $this->conn->prepare($sql);
        $stmt->execute(['title' => $title, 'note' => $note, 'id' => $id]);
        return true;
    }


    // Delete Note of An User
    public function delete_note($id)
    {
        $sql = "DELETE FROM notes WHERE id = :id";
        $stmt = $this->conn->prepare($sql);
        $stmt->execute(['id' => $id]);

        return true;
    }

    //*****************************  EDIT PROFILE ****************************** */

    // Update Profile of An User
    public function update_profile($name, $gender, $dob, $phone, $photo, $id)
    {
        $sql = "UPDATE users SET name= :name, gender= :gender, dob= :dob, phone= :phone, photo= :photo WHERE id = :id AND deleted !=0 ";
        $stmt = $this->conn->prepare($sql);
        $stmt->execute(['name' => $name, 'gender' => $gender, 'dob' => $dob, 'phone' => $phone, 'photo' => $photo, 'id' => $id]);
        return true;
    }

    // Change Password of An User
    public function change_password($pass, $id)
    {
        $sql = "UPDATE users SET password = :pass WHERE id= :id AND deleted != 0";
        $stmt = $this->conn->prepare($sql);
        $stmt->execute(['pass' => $pass, 'id' => $id]);
        return true;
    }

    // Verify E-Mail of An User
    public function verify_email($email)
    {
        $sql = "UPDATE users SET verified=1 WHERE email= :email AND deleted != 0";
        $stmt = $this->conn->prepare($sql);
        $stmt->execute(['email' => $email]);
        return true;
    }


    // ************************** FEEDBACK **************************

    // Send Feedback to Admin
    public function send_feedback($sub, $feed, $user_id)
    {
        $sql = "INSERT INTO feedback (user_id, subject, feedback) VALUES (:user_id, :sub, :feed)";
        $stmt = $this->conn->prepare($sql);
        $stmt->execute(['user_id' => $user_id, 'sub' => $sub, 'feed' => $feed]);
        return true;
    }


    // ************************** Notification **************************

    // Insert Notification
    public function notification($user_id, $type,  $message)
    {
        $sql = "INSERT INTO notification (user_id, type, message) VALUES (:user_id, :type, :message)";
        $stmt =  $this->conn->prepare($sql);
        $stmt->execute(['user_id' => $user_id, 'type' => $type, 'message' => $message]);
        return true;
    }


    // Fetch NOtification
    public function fetchNotification($user_id)
    {
        $sql = "SELECT * FROM notification WHERE user_id = :user_id AND type = 'user'";
        $stmt = $this->conn->prepare($sql);
        $stmt->execute(['user_id' => $user_id]);

        $result = $stmt->fetchAll(PDO::FETCH_ASSOC);
        return $result;
    }

    // Remove Notification
    public function removeNotification($id)
    {
        $sql = "DELETE FROM notification WHERE id = :id AND type = 'user'";
        $stmt = $this->conn->prepare($sql);
        $stmt->execute(['id' => $id]);
        return true;
    }
}
