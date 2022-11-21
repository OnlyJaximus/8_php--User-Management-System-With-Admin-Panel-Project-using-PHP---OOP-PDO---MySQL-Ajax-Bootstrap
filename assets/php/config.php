<?php



class Database
{

    const USERNAME = 'testmercatesting@gmail.com';
    const PASSWORD = 'taixffwsdcugkybp';
    //const PASSWORD = "xaibdlprvlhgcilz";

    // data source network
    private $dsn = "mysql:host=localhost;dbname=db_user_system";
    private $dbuser = "root";
    private $dbpass = "";

    public $conn;

    public function __construct()
    {
        try {
            $this->conn = new PDO($this->dsn, $this->dbuser, $this->dbpass);

            // echo 'Connected Successfully to the database!';
        } catch (PDOException $e) {
            echo 'Error : ' . $e->getMessage();
        }

        return $this->conn;
    }

    // Checking Input
    public function test_input($data)
    {
        $data = trim($data);  // The Trim method removes from the current string all leading and trailing white-space characters.
        $data =  stripslashes($data);  // The stripslashes() function removes backslashes 
        $data =  htmlspecialchars($data); //The htmlspecialchars() function converts special characters to HTML entities. This means that it will replace HTML characters like < and > with &lt; and &gt;. This prevents attackers from exploiting the code by injecting HTML or Javascript code (Cross-site Scripting attacks) in forms.
        return $data;
    }

    // Error Success Message Alert
    public function showMessage($type, $message)
    {
        return '<div class="alert alert-' . $type . ' alert-dismissible">
                    <button type="button" class="close" data-dismiss="alert">&times;</button>
                    <strong class="text-center">' . $message . '</strong>
                </div>';
    }

    // Display time in ago
    public function timeInAgo($timestamp)
    {
        date_default_timezone_set('Europe/Belgrade');

        $timestamp =  strtotime($timestamp) ? strtotime($timestamp) : $timestamp; // returning time in seconds

        $time = time() - $timestamp;

        switch ($time) {
                //Seconds
            case $time <= 60:
                return 'Just Now';
                // Minutes
            case $time >= 60 && $time < 3600: // 1 houe
                return (round($time / 60) == 1) ? 'a minut ago' : round($time / 60) . ' minutes ago';
                // Hours
            case $time >= 3600 && $time < 86400: // 1 houe
                return (round($time / 3600) == 1) ? 'an hour ago' : round($time / 3600) . ' hours ago';
                // Days
            case $time >= 86400 && $time < 604800:
                return (round($time / 86400) == 1) ? 'a day ago' : round($time / 86400) . ' days ago';
                // Weeks
            case $time >= 604800 && $time < 2600640:
                return (round($time / 604800) == 1) ? 'a week ago' : round($time / 604800) . ' weeks ago';
                // Months
            case $time >= 2600640 && $time < 31207680:
                return (round($time / 2600640) == 1) ? 'a month ago' : round($time / 2600640) . ' months ago';
                // Years
            case $time >= 31207680;
                return (round($time / 31207680) == 1) ? 'a year ago' : round($time / 31207680) . ' years ago';
        }
    }
}

// $ob = new Database();
