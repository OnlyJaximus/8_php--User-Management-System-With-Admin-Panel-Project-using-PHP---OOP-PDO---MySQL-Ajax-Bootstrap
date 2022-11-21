<?php session_start();
if (isset($_SESSION['user'])) {
    header('location:home.php');
}

include_once 'assets/php/config.php';
$db = new Database();

$sql = "UPDATE visitors SET hits = hits+1 WHERE id = 0";
$stmt = $db->conn->prepare($sql);
$stmt->execute();

?>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Blex Ecommerce</title>
    <link rel="stylesheet" href="assets/css/bootstrap.min.css">
    <link rel="stylesheet" href="assets/css/style.css">
    <!-- https://cdnjs.com/libraries/twitter-bootstrap/4.4.1 -->
    <!-- <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/twitter-bootstrap/4.4.1/css/bootstrap.min.css"> -->

</head>

<body>
    <div class="container">
        <!-- Login Form Start -->
        <div class="row justify-content-center wrapper" id="login-box">
            <div class="col-lg-10 my-auto">
                <div class="card-group myShadow">
                    <div class="card rounded-left p-4" style="flex-grow:1.4;">
                        <h1 class="text-center font-weight-bold text-primary">Sign in to Account</h1>
                        <!--    my->margin bottom and top / px ->padding left & right-->
                        <hr class="my-3">
                        <form action="" method="POST" class="px-3" id="login-form">
                            <div id="loginAlert"></div>
                            <!-- Email -->
                            <div class="input-group input-group-lg form-group">
                                <div class="input-group-prepend">
                                    <span class="input-group-text rounded-0">
                                        <i class="far fa-envelope fa-lg" aria-hidden="true"></i>
                                    </span>
                                </div>
                                <input type="email" name="email" id="email" class="form-control rounded-0" placeholder="E-Mail" required value="<?php if (isset($_COOKIE['email'])) {
                                                                                                                                                    echo $_COOKIE['email'];
                                                                                                                                                } ?>">
                            </div>

                            <!-- Password -->
                            <div class=" input-group input-group-lg form-group">
                                <div class="input-group-prepend">
                                    <span class="input-group-text rounded-0">
                                        <i class="fas fa-key fa-lg" aria-hidden="true"></i>
                                    </span>
                                </div>
                                <input type="password" name="password" id="password" class="form-control rounded-0" placeholder="Password" required value="<?php if (isset($_COOKIE['password'])) {
                                                                                                                                                                echo $_COOKIE['password'];
                                                                                                                                                            } ?>">
                            </div>
                            <!-- Forgot Password -->
                            <div class="form-group">
                                <div class="custom-control custom-checkbox float-left">
                                    <input type="checkbox" name="rem" class="custom-control-input" id="customCheck" <?php if (isset($_COOKIE['email'])) { ?> checked <?php } ?>>

                                    <label for="customCheck" class="custom-control-label">Remember Me</label>
                                </div>
                                <div class="forgot float-right">
                                    <a href="#" id="forgot-link">Forgot Password?</a>
                                </div>
                                <div class="clearFix"></div>
                            </div>
                            <!-- Button -->
                            <div class="form-group">
                                <input type="submit" value="Sign In" id="login-btn" class="btn btn-primary btn-lg btn-block myBtn">
                            </div>
                        </form>
                    </div>
                    <div class="card justify-content-center roundend-right myColor p-4">
                        <h1 class="text-center font-weight-bold text-white">Hello Friends!</h1>
                        <hr class="my-3 bg-light myHr">
                        <p class="text-center font-weight-bolder text-light lead">Enter your personal details and start your journey with us!</p>
                        <button class="btn btn-outline-light btn-lg align-self-center font-weight-bolder mt-4 myLinkBtn" id="register-link">Sign Up</button>
                    </div>
                </div>
            </div>
        </div>
        <!-- Login Form End -->

        <!-- Register From Start -->
        <div class="row justify-content-center wrapper" id="register-box" style="display: none;">
            <div class="col-lg-10 my-auto">
                <div class="card-group myShadow">
                    <div class="card justify-content-center roundend-left myColor p-4">
                        <h1 class="text-center font-weight-bold text-white">Welcome Back!</h1>
                        <hr class="my-3 bg-light myHr">
                        <p class="text-center font-weight-bolder text-light lead">To keep connected with us please login with your personal info.</p>
                        <button class="btn btn-outline-light btn-lg align-self-center font-weight-bolder mt-4 myLinkBtn" id="login-link">Sign In</button>
                    </div>
                    <div class="card rounded-right p-4" style="flex-grow:1.4;">
                        <h1 class="text-center font-weight-bold text-primary">Create Account</h1>
                        <!--    my->margin bottom and top / px ->padding left & right-->
                        <hr class="my-3">
                        <!-- FORM ************************* -->
                        <form action="" method="POST" class="px-3" id="register-form">
                            <div id="regAlert"></div>
                            <!-- NAME -->
                            <div class="input-group input-group-lg form-group">
                                <div class="input-group-prepend">
                                    <span class="input-group-text rounded-0">
                                        <i class="far fa-user fa-lg" aria-hidden="true"></i>
                                    </span>
                                </div>
                                <input type="text" name="name" id="name" class="form-control rounded-0" placeholder="Full Name" required>
                            </div>

                            <div class="input-group input-group-lg form-group">
                                <div class="input-group-prepend">
                                    <span class="input-group-text rounded-0">
                                        <i class="far fa-envelope fa-lg" aria-hidden="true"></i>
                                    </span>
                                </div>
                                <input type="email" name="email" id="remail" class="form-control rounded-0" placeholder="E-Mail" required>
                            </div>

                            <!-- Password ***********   -->
                            <div class="input-group input-group-lg form-group">
                                <div class="input-group-prepend">
                                    <span class="input-group-text rounded-0">
                                        <i class="fas fa-key fa-lg" aria-hidden="true"></i>
                                    </span>
                                </div>
                                <input type="password" name="password" id="rpassword" class="form-control rounded-0" placeholder="Password" required minlength="5">
                            </div>

                            <!-- Confirm Passworrd ******************  -->
                            <div class="input-group input-group-lg form-group">
                                <div class="input-group-prepend">
                                    <span class="input-group-text rounded-0">
                                        <i class="fas fa-key fa-lg" aria-hidden="true"></i>
                                    </span>
                                </div>
                                <input type="password" name="cpassword" id="cpassword" class="form-control rounded-0" placeholder="Confirm Password" required minlength="5">
                            </div>

                            <div class="form-group">
                                <div id="passError" class="text-danger font-weight-bold"></div>
                            </div>

                            <div class="form-group">
                                <input type="submit" value="Sign Up" id="register-btn" class="btn btn-primary btn-lg btn-block myBtn">
                            </div>
                        </form>
                    </div>

                </div>
            </div>
        </div>
        <!-- Register From End -->

        <!-- Forgot Password Form Start -->
        <div class="row justify-content-center wrapper" id="forgot-box" style="display: none;">
            <div class="col-lg-10 my-auto">
                <div class="card-group myShadow">
                    <div class="card justify-content-center roundend-left myColor p-4">
                        <h1 class="text-center font-weight-bold text-white">Reset Password</h1>
                        <hr class="my-3 bg-light myHr">
                        <button class="btn btn-outline-light btn-lg align-self-center font-weight-bolder mt-4 myLinkBtn" id="back-link">Back</button>
                    </div>
                    <div class="card rounded-right p-4" style="flex-grow:1.4;">
                        <h1 class="text-center font-weight-bold text-primary">Forgot Your Password</h1>
                        <hr class="my-3">
                        <p class="lead text-center text-sm-secondary">To reset your password, enter the registered e-mail address and we will send you the rest instructions on your e-mail!</p>
                        <form action="" method="POST" class="px-3" id="forgot-form">
                            <div id="forgotAlert"></div>
                            <div class="input-group input-group-lg form-group">
                                <div class="input-group-prepend">
                                    <span class="input-group-text rounded-0">
                                        <i class="far fa-envelope fa-lg" aria-hidden="true"></i>
                                    </span>
                                </div>
                                <input type="email" name="email" id="femail" class="form-control rounded-0" placeholder="E-Mail" required>
                            </div>
                            <div class="form-group">
                                <input type="submit" value="Reset Password" id="forgot-btn" class="btn btn-primary btn-lg btn-block myBtn">
                            </div>
                        </form>
                    </div>

                </div>
            </div>
        </div>
        <!-- Forgot Password Form End -->
    </div>

</body>

<script src="assets/js/jquery.min.js"></script>
<script src="assets/js/bootstrap.bundle.min.js"></script>

<!-- <script src="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.12.1/js/all.min.js"></script> -->
<script src="assets/js/all.min.js"></script>

<script type="text/javascript">
    // checkValidity(), Returns true if an input element contains valid data.


    $(document).ready(function() {
        // alert('Hello');
        $('#register-link').click(function() {
            $('#login-box').hide();
            $('#register-box').show();
        });

        $('#login-link').click(function() {
            $('#login-box').show();
            $('#register-box').hide();

        });

        $('#forgot-link').click(function() {
            $('#login-box').hide();
            $('#forgot-box').show();
        });

        $('#back-link').click(function() {
            $('#forgot-box').hide();
            $('#login-box').show();
        });

        //  *********  Register Ajax Request  *******
        $("#register-btn").click(function(e) {
            //alert('Hello');
            if ($('#register-form')[0].checkValidity()) {
                e.preventDefault();
                $('#register-btn').val('Please Wait...');
                if ($("#rpassword").val() != $("#cpassword").val()) {
                    // console.log("Not Matched!");
                    $("#passError").text('* Password did not matched');
                    $('#register-btn').val('Sign Up');
                } else {
                    $("#passError").text('');
                    $.ajax({
                        url: 'assets/php/action.php',
                        method: 'post',
                        data: $('#register-form').serialize() + '&action=register', // serialize->all input in array

                        success: function(response) {
                            $('#register-btn').val('Sign Up');
                            console.log(response);
                            if (response === 'register') {
                                window.location = 'home.php';
                            } else {
                                $("#regAlert").html(response);
                            }
                        }
                    });
                }
            }
        });

        //Login Ajax Request
        $("#login-btn").click(function(e) {
            if ($('#login-form')[0].checkValidity()) {
                e.preventDefault();

                $("#login-btn").val('Please Wait...');
                $.ajax({
                    url: 'assets/php/action.php',
                    method: 'POST',
                    data: $('#login-form').serialize() + '&action=login',

                    success: function(response) {
                        // console.log(response);
                        if (response === 'login') {
                            window.location = 'home.php';
                            $("#login-btn").val('Sign In');
                        } else {
                            $("#loginAlert").html(response);
                        }

                    }
                });
            }
        });

        //Forgot Password Ajax Request
        $("#forgot-btn").click(function(e) {
            if ($("#forgot-form")[0].checkValidity()) {
                e.preventDefault();

                $("#forgot-btn").val('Please Wait...');

                $.ajax({
                    url: 'assets/php/action.php',
                    method: 'post',
                    data: $("#forgot-form").serialize() + '&action=forgot',
                    success: function(response) {
                        // console.log(response);  // Array (  [email] => danilo@gmail.com   [action] => forgot)
                        $("#forgot-btn").val('Reset Password');
                        $("#forgot-form")[0].reset();
                        $("#forgotAlert").html(response);

                    }
                });
            }
        });





    });
</script>

</html>