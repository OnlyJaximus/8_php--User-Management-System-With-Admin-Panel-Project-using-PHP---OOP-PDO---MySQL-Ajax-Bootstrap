<?php
require_once 'config.php';

class Admin extends Database
{

    //Admin login
    public function admin_login($username, $password)
    {
        $sql = "SELECT username, password FROM admin WHERE username = :username AND password = :password";
        $stmt = $this->conn->prepare($sql);
        $stmt->execute(['username' => $username, 'password' => $password]);

        $row = $stmt->fetch(PDO::FETCH_ASSOC);
        return $row;
    }

    // Count Total Number of Rows
    public function total_count($tablename)
    {
        $sql = "SELECT * FROM $tablename";
        $stmt = $this->conn->prepare($sql);
        $stmt->execute();

        $count = $stmt->rowCount();
        return $count;
    }

    // Count Total Verified Users
    public function verified_users($status)
    {
        $sql = "SELECT * FROM users WHERE verified = :status";
        $stmt = $this->conn->prepare($sql);
        $stmt->execute(['status' => $status]);

        $count = $stmt->rowCount();
        return $count;
    }

    // Gender Percentage
    public function genderPer()
    {
        // COUNT(*) returns the number of rows in a specified table
        $sql = "SELECT gender, COUNT(*) AS number FROM users WHERE gender != '' GROUP BY gender";
        // gender      number
        // Female      1
        // Male        3
        $stmt = $this->conn->prepare($sql);
        $stmt->execute();
        $result = $stmt->fetchAll(PDO::FETCH_ASSOC);

        return $result;
    }

    // Users Verified/Unverified Percentage
    public function verifiedPer()
    {
        $sql = "SELECT verified, COUNT(*) AS number FROM users GROUP BY verified";
        // verified                         number
        // 0(user is not verified)            7
        // 1                                  2
        $stmt = $this->conn->prepare($sql);
        $stmt->execute();
        $results = $stmt->fetchAll(PDO::FETCH_ASSOC);
        return $results;
    }

    // Count Website Hits
    public function site_hits()
    {
        $sql = "SELECT hits FROM visitors";
        $stmt = $this->conn->prepare($sql);
        $stmt->execute();
        $count = $stmt->fetch(PDO::FETCH_ASSOC);
        return $count;
    }

    //Fetch All Registered Users
    public function fetchAllUsers($val)
    {
        $sql = "SELECT * FROM users WHERE deleted != $val";
        $stmt = $this->conn->prepare($sql);
        $stmt->execute();
        $result = $stmt->fetchAll(PDO::FETCH_ASSOC);
        return $result;
    }

    // Fetch User's Details by ID
    public function fetchUserDetailsByID($id)
    {
        $sql = "SELECT * FROM users WHERE id = :id AND deleted != 0";
        $stmt = $this->conn->prepare($sql);
        $stmt->execute(['id' => $id]);

        $result = $stmt->fetch(PDO::FETCH_ASSOC);

        return $result;
    }

    // Delete An User
    public function userAction($id, $val)
    {
        $sql = "UPDATE users SET deleted = $val WHERE id = :id";
        $stmt = $this->conn->prepare($sql);
        $stmt->execute(['id' => $id]);

        return true;
    }

    // Fetch All Notes With User Info
    public function fetchAllNotes()
    {
        $sql = "SELECT notes.id, notes.title, notes.note, notes.created_at, notes.updated_at, users.name, users.email
                FROM notes INNER JOIN users 
                ON notes.user_id = users.id";

        $stmt = $this->conn->prepare($sql);
        $stmt->execute();
        $result =  $stmt->fetchAll(PDO::FETCH_ASSOC);

        return $result;
    }

    // Delete A Note Of An User By Admin
    public function deleteNote($id)
    {
        $sql = "DELETE FROM notes WHERE id = :id";
        $stmt = $this->conn->prepare($sql);
        $stmt->execute(['id' => $id]);
        return true;
    }

    // Fetch All Feedback Of Users
    public function fetchFeedback()
    {
        $sql = "SELECT feedback.id, feedback.subject, feedback.feedback, feedback.created_at, feedback.user_id, users.name, users.email
                FROM feedback INNER JOIN users
                ON feedback.user_id = users.id
                WHERE replied != 1 
                ORDER BY feedback.id DESC";
        $stmt = $this->conn->prepare($sql);
        $stmt->execute();

        $result = $stmt->fetchAll(PDO::FETCH_ASSOC);
        return $result;
    }

    // Reply To User
    public function replyFeedback($user_id, $message)
    {
        $sql = "INSERT INTO notification (user_id, type, message) VALUES (:uid, 'user', :message)";
        $stmt = $this->conn->prepare($sql);
        $stmt->execute(['uid' => $user_id, 'message' => $message]);
        return true;
    }

    // Set Feedback Replied
    public function feeddbackReplied($feedback_id)
    {
        $sql = "UPDATE feedback SET replied = 1 WHERE id = :feedback_id";
        $stmt = $this->conn->prepare($sql);
        $stmt->execute(['feedback_id' => $feedback_id]);
        return true;
    }

    // Fetch Notification From DB
    public function fetchNotification()
    {
        $sql = "SELECT notification.id, notification.message, notification.created_at, users.name, users.email
                FROM notification
                INNER JOIN users
                ON notification.user_id = users.id
                WHERE type = 'admin' 
                ORDER BY notification.id DESC LIMIT 5";
        $stmt = $this->conn->prepare($sql);
        $stmt->execute();

        $result = $stmt->fetchAll(PDO::FETCH_ASSOC);
        return $result;
    }

    // Remove Notification
    public function removeNotification($id)
    {
        $sql = "DELETE FROM notification  WHERE id = :id AND type = 'admin' ";
        $stmt = $this->conn->prepare($sql);
        $stmt->execute(['id' => $id]);
        return true;
    }


    // Fetch All Users From DB
    public function exportAllUsers()
    {
        $sql = "SELECT * FROM users";
        $stmt = $this->conn->prepare($sql);
        $stmt->execute();

        $result = $stmt->fetchAll(PDO::FETCH_ASSOC);
        return $result;
    }
}
