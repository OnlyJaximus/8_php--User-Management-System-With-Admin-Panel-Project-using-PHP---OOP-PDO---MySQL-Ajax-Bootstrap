<?php require_once('assets/php/auth.php');
$user = new Auth();

$msg = '';

if (isset($_GET['email']) && isset($_GET['token'])) {
    $email = $user->test_input($_GET['email']);
    $token = $user->test_input($_GET['token']);

    $auth_user = $user->reset_pass_auth($email, $token);

    if ($auth_user != NULL) {
        if (isset($_POST['submit'])) {
            $newpass =  $_POST['pass'];
            $cnewpass =  $_POST['cpass'];

            $hnewpass = password_hash($newpass, PASSWORD_DEFAULT);

            if ($newpass == $cnewpass) {
                $user->update_new_pas($hnewpass, $email);
                $msg =  'Passowrd Changed Successfully!<br><a href="index.php">Login Here!</a>';
            } else {
                $msg =  'Password did not matched!';
            }
        }
    } else {
        header('Location: index.php');
        exit();
    }
} else {
    header('Location: index.php');
    exit();
}

?>

<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Reset Password</title>
    <link rel="stylesheet" href="assets/css/bootstrap.min.css">
    <link rel="stylesheet" href="assets/css/style.css">
    <!-- https://cdnjs.com/libraries/twitter-bootstrap/4.4.1 -->
    <!-- <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/twitter-bootstrap/4.4.1/css/bootstrap.min.css"> -->

</head>

<body>
    <div class="container">
        <!-- Login Form Start -->
        <div class="row justify-content-center wrapper">
            <div class="col-lg-10 my-auto">
                <div class="card-group myShadow">

                    <div class="card justify-content-center roundend-left myColor p-4">
                        <h1 class="text-center font-weight-bold text-white">Reset Your Password Here!</h1>

                    </div>

                    <div class="card rounded-right p-4" style="flex-grow:2;">
                        <h1 class="text-center font-weight-bold text-primary">Enter New Password!</h1>
                        <hr class="my-3">
                        <form action="" method="POST" class="px-3">
                            <div class="text-center lead mb-2"><?php echo $msg ?></div>
                            <!-- Password -->
                            <div class=" input-group input-group-lg form-group">
                                <div class="input-group-prepend">
                                    <span class="input-group-text rounded-0">
                                        <i class="fas fa-key fa-lg" aria-hidden="true"></i>
                                    </span>
                                </div>
                                <input type="password" name="pass" class="form-control rounded-0" placeholder="New Password" required minlength="5">
                            </div>

                            <!-- Confirm New Password -->
                            <div class=" input-group input-group-lg form-group">
                                <div class="input-group-prepend">
                                    <span class="input-group-text rounded-0">
                                        <i class="fas fa-key fa-lg" aria-hidden="true"></i>
                                    </span>
                                </div>
                                <input type="password" name="cpass" class="form-control rounded-0" placeholder="Confirm New Password" required minlength="5">
                            </div>


                            <!-- Button -->
                            <div class="form-group">
                                <input type="submit" value="Reset Password" name="submit" class="btn btn-primary btn-lg btn-block myBtn">
                            </div>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <script src="assets/js/all.min.js"></script>
</body>

</html>