<?php
session_start(); // Start the session

use PHPMailer\PHPMailer\PHPMailer;
use PHPMailer\PHPMailer\SMTP;
use PHPMailer\PHPMailer\Exception;

// Load Composer's autoloader
require 'vendor/autoload.php';
require_once 'connection.php';


// Check if the form is submitted
if ($_SERVER["REQUEST_METHOD"] == "POST" && isset($_POST['send_email'])) {
    // Generate 6-digit random authentication code
    $auth_code = mt_rand(100000, 999999); // Moved this line here

    // Store the auth code in the session
    $_SESSION['auth_code'] = $auth_code;

    $_SESSION['registration_data'] = [
        'firstname' => $_POST['firstname'],
        'lastname' => $_POST['lastname'],
        'recipient_email' => $_POST['recipient_email'],
        'typepassword' => $_POST['typepassword']
    ];
    
    // Get the email address entered by the user
    $recipient_email = $_POST['recipient_email'];

    $firstname = $_POST['firstname'];
    $lastname = $_POST['lastname'];

    // Check if password and confirm password match
    if ($_POST['typepassword'] != $_POST['confirmPassword']) {
        echo '<script>alert("Password and Confirm Password do not match!");</script>';
        echo '<script>
                document.getElementById("typepassword").style.borderColor = "red";
                document.getElementById("confirmPassword").style.borderColor = "red";
                setTimeout(function() {
                    document.getElementById("typepassword").style.borderColor = "";
                    document.getElementById("confirmPassword").style.borderColor = "";
                }, 5000);
              </script>';
    } else if (!preg_match('/^(?=.*\d)(?=.*[A-Za-z])(?=.*[^A-Za-z0-9])(?=.*[a-zA-Z]).{5,}$/', $_POST['typepassword'])) {
        echo '<script>alert("Password must contain at least 1 uppercase or lowercase letter, 1 symbol, 1 number, and be at least 5 characters long!");</script>';
        echo '<script>
                document.getElementById("typepassword").style.borderColor = "red";
                setTimeout(function() {
                    document.getElementById("typepassword").style.borderColor = "";
                }, 5000);
              </script>';
    } else {
        // Create an instance; passing true enables exceptions
        $mail = new PHPMailer(true);

        try {
            // Server settings
            $mail->SMTPDebug = 0; // Disable verbose debug output
            $mail->isSMTP();                                            // Send using SMTP
            $mail->Host       = 'smtp.gmail.com';                      // Set the SMTP server to send through
            $mail->SMTPAuth   = true;                                   // Enable SMTP authentication
            $mail->Username   = 'ust acc mo';      // SMTP username
            $mail->Password   = 'pass mo';                         // SMTP password
            $mail->SMTPSecure = 'tls';
            $mail->Port       = 587;                                    // TCP port to connect to
            $mail->SMTPOptions = array(
                'ssl' => array(
                    'verify_peer' => false,
                    'verify_peer_name' => false,
                    'allow_self_signed' => true
                )
            );
            // Recipients
            $mail->setFrom('ust acc mo', 'ECOncern');
            $mail->addAddress($recipient_email);                       // Add the recipient email entered by the user

            // Content
            $mail->isHTML(true);                                        // Set email format to HTML
            $mail->Subject = 'Authentication Code';
            $mail->Body    = "Hello " . $firstname . " " . $lastname . ",
            <br><br>
            Thank you for registering at ECOncern.
            <br><br>
            We're delighted to have you join our community dedicated to environmental conservation and sustainability. Your registration marks the beginning of an exciting journey towards making a positive impact on our planet.
            <br><br>
            At ECOncern, we believe in collective action and the power of individuals coming together to address environmental challenges. By registering with us, you've taken the first step towards being part of this movement.
            <br><br>
            As a registered member, you'll have access to a wealth of resources, tools, and opportunities to contribute to environmental conservation efforts. Whether it's participating in community clean-up events, spreading awareness about sustainable practices, or engaging in advocacy campaigns, there are numerous ways for you to get involved.
            <br><br>
            We encourage you to explore our platform, connect with like-minded individuals, and discover how you can make a difference in protecting our planet for future generations.
            <br><br>
            Once again, thank you for choosing to be a part of ECOncern. Together, we can create a greener, more sustainable world.
            <br><br>
            Here is your Authentication Code: <b style='font-size: 20px;'>" . $auth_code . "</b>";

            $mail->send();

            // Redirect to otp.php after sending email
            header("Location: authentication.php");
            exit();
        } catch (Exception $e) {
        }
    }
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>ECOncern - Registration</title>
    <link href="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" type="text/css" href="reg_styles.css">
    <link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.15.4/css/all.min.css" rel="stylesheet">
    <link rel="shortcut icon" type="image/png" href="favicon.png">

</head>
<body>
    <header class="header-1">
        <div class="headerlogo">
            <img src="header-title.png" alt="Logo" class="logo">
        </div>
        <nav class="navbar">
            <div class="burger-menu" id="burger-menu">
                <div class="bar"></div>
                <div class="bar"></div>
                <div class="bar"></div>
            </div>
            
            <div class="navbar-buttons" id="navbar-buttons">
                <button>Home</button>
                <button>About</button>
                <button>Services</button>
                <button>Contact</button>
            </div>
        </nav>
    </header>  

    <div class="loading-screen" id="loader">
        <div class="loader">
          <span class="item"></span>
          <span class="item"></span>
          <span class="item"></span>
          <span class="item"></span>
        </div>
    </div>

    <div class="container">
        <div class="intro-text">
            <h2>Welcome to ECOncern</h2>
            <p>Register Now to Join Our Quest in Saving the Environment</p>
        </div>
        <form class="form" id="registration-form" method="post" action="<?php echo htmlspecialchars($_SERVER["PHP_SELF"]); ?>">
            <p class="title">Register </p>
            <p class="message">Sign Up now and get access to ECOncern. </p>
            <div class="flex">
                <label>
                    <input required="" placeholder="" type="text" class="input" id="firstname" name="firstname" autocomplete="off">
                    <span>Firstname</span>
                </label>

                <label>
                    <input required="" placeholder="" type="text" class="input" id="lastname" name="lastname" autocomplete="off">
                    <span>Lastname</span>
                </label>
            </div>  
                
            <label>
                <input required="" placeholder="" type="email" class="input" id="recipient_email" name="recipient_email" autocomplete="off">
                <span>Email</span>
            </label> 
                
            <label class="password-input">
    <input required="" placeholder="" type="password" class="input" id="typepassword" name="typepassword" autocomplete="off">
    <span>Password (Mix case, nums, symbols, 5+ chars)</span>
    <i class="fas fa-eye" id="togglePassword1"></i>
</label>
<label class="password-input">
    <input required="" placeholder="" type="password" class="input" id="confirmPassword" name="confirmPassword" autocomplete="off">
    <span>Confirm password</span>
    <i class="fas fa-eye" id="togglePassword2"></i>
</label>

            <button type="submit" class="submit" name="send_email">Submit</button>
            <p class="signin">Already have an account? <a href="#">Sign in</a></p>
        </form>
    </div>
    <footer>
    </footer>

    <script src="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/js/bootstrap.min.js"></script>
    <script src="https://kit.fontawesome.com/a560976b07.js" crossorigin="anonymous"></script>
    <script>
        window.addEventListener('load', function(){
            setTimeout(function(){
                var loadingScreen = document.getElementById('loader');
                loadingScreen.classList.add('fade-out'); // Apply fade-out animation
                setTimeout(function() {
                    loadingScreen.classList.add('hidden'); // Hide the loading screen after animation
                }, 200);
            }, 2000);
        });

        document.getElementById("burger-menu").addEventListener("click", function() {
            this.classList.toggle("active"); // Toggle active class on burger menu icon
            document.querySelector(".navbar-buttons").classList.toggle("active"); // Toggle active class on navbar buttons
            document.querySelector(".container").classList.toggle("pushed-down"); // Toggle pushed-down class on container
        });

        // Validate password and confirm password
// Validate password and confirm password
document.getElementById("registration-form").addEventListener("submit", function(event) {
    var typepassword = document.getElementById("typepassword").value;
    var confirmPassword = document.getElementById("confirmPassword").value;

    if (typepassword !== confirmPassword) {
        event.preventDefault();

        // Alert the user about password mismatch
        alert("Password and Confirm Password do not match!");

        // Highlight the fields with red border
        document.getElementById("typepassword").style.borderColor = "red";
        document.getElementById("confirmPassword").style.borderColor = "red";

        // Remove red border after 5 seconds
        setTimeout(function() {
            document.getElementById("typepassword").style.borderColor = "";
            document.getElementById("confirmPassword").style.borderColor = "";
        }, 5000);
    } else if (!typepassword.match(/^(?=.*\d)(?=.*[a-zA-Z])(?=.*[^a-zA-Z\d]).{5,}$/)) {
        event.preventDefault();

        // Alert the user about password complexity requirement
        alert("Password must contain at least 1 uppercase or lowercase letter, 1 symbol, 1 number, and be at least 5 characters long!");

        // Highlight the password field with red border
        document.getElementById("typepassword").style.borderColor = "red";

        // Remove red border after 5 seconds
        setTimeout(function() {
            document.getElementById("typepassword").style.borderColor = "";
        }, 5000);
    }
});

document.getElementById("togglePassword1").addEventListener("click", function() {
    var typepasswordInput = document.getElementById("typepassword");
    if (typepasswordInput.type === "password") {
        typepasswordInput.type = "text";
    } else {
        typepasswordInput.type = "password";
    }
});

document.getElementById("togglePassword2").addEventListener("click", function() {
    var confirmPasswordInput = document.getElementById("confirmPassword");
    if (confirmPasswordInput.type === "password") {
        confirmPasswordInput.type = "text";
    } else {
        confirmPasswordInput.type = "password";
    }
});

    </script>
</body>
</html>
