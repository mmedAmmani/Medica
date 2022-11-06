<?php
// Initialize the session
session_start();
 
// Check if the user is already logged in, if yes then redirect him to welcome page
if(isset($_SESSION["loggedin"]) && $_SESSION["loggedin"] === true){
    if($_SESSION["role"] == 'secretaire'){
        header("location:secretaire/acceuil.php");
    } else {
        header("location:medecin/acceuil.php");
    }
    exit;
}
 
// Include config file
require_once "config.php";
 
// Define variables and initialize with empty values
$username = $password = "";
$username_err = $password_err = $login_err = "";
 
// Processing form data when form is submitted
if($_SERVER["REQUEST_METHOD"] == "POST"){
    // Check if username is empty
    if(empty(trim($_POST["username"]))){
        $username_err = "Please enter username.";
    } else{
        $username = trim($_POST["username"]);
    }
    
    // Check if password is empty
    if(empty(trim($_POST["password"]))){
        $password_err = "Please enter your password.";
    } else{
        $password = trim($_POST["password"]);
    }
    
    // Validate credentials
    if(empty($username_err) && empty($password_err)){
        // Prepare a select statement
        $sql = "SELECT * FROM utilisateur WHERE username = ?";
            $stmt = mysqli_prepare($link, $sql);
            if(!$stmt) {
                die('mysqli error: '.mysqli_error($link));
            }
            // Bind variables to the prepared statement as parameters
            mysqli_stmt_bind_param($stmt, "s", $param_username);
            
            // Set parameters
            $param_username = $username;
            // Attempt to execute the prepared statement
            if(mysqli_stmt_execute($stmt)){
                // Store result
                mysqli_stmt_store_result($stmt);
                
                // Check if username exists, if yes then verify password
                if(mysqli_stmt_num_rows($stmt) == 1){                    
                    // Bind result variables
                    mysqli_stmt_bind_result($stmt, $id, $username , $hashed_password, $role);
                    if(mysqli_stmt_fetch($stmt)){
                        if(password_verify($password, $hashed_password)){
                            // Password is correct, so start a new session
                            session_start();
                            
                            // Store data in session variables
                            $_SESSION["loggedin"] = true;
                            $_SESSION["id"] = $id;
                            $_SESSION["username"] = $username;                            
                            $_SESSION["role"] = $role;                            
                            
                            // Redirect user to welcome page
                            if($role == "secretaire"){
                                header("location:secretaire/acceuil.php");
                            } else {
                                header("location:medecin/acceuil.php");
                            }
                        } else{
                            // Password is not valid, display a generic error message
                            $login_err = "Invalid username or password.";
                        }
                    }
                } else{
                    // Username doesn't exist, display a generic error message
                    $login_err = "Invalid username or password.";
                }
            } else{
                echo "Oops! Something went wrong. Please try again later.";
            }

            // Close statement
            mysqli_stmt_close($stmt);
    }
    
    // Close connection
    mysqli_close($link);
}
?>
<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8" />
    <meta http-equiv="X-UA-Compatible" content="IE=edge" />
    <meta name="viewport" content="width=device-width, initial-scale=1.0" />
    <link rel="stylesheet" href="css/login.css" />
    <title>medica | gestion medicale | cabinet medicale</title>
</head>
<style>
.img-container {
    width: 100%;
    height: 100%;
    flex: 1;
    background: url('img/doctor.jpg') center center/cover;
    border-radius: 5px;
}

.error {
    background: rgba(227, 16, 16, 0.7);
    text-align: center;
    color: #eee;
    padding: 5px;
    border-radius: 5px;
}
</style>

<body>
    <form action="<?php echo htmlspecialchars($_SERVER["PHP_SELF"]); ?>" method="post">
        <div class="main">
            <div class="img-container"></div>
            <div class="login">
                <div class="container">
                    <h1>Med<span><img src="img/logo.svg" alt=" "></span>ica</h1>
                    <h3>Welcome to <span>Medica</span></h3>
                    <?php 
                        if(!empty($login_err)){
                            echo '<div class="error">' . $login_err . '</div>';
                        }        
                    ?>
                    <div class="form-input">
                        <label for="login">username:</label>
                        <input type="text" name='username' placeholder="Enter your Email" />
                    </div>
                    <div class="form-input">
                        <label for="password">password:</label>
                        <input type="password" name='password' placeholder="Enter your Password" />
                    </div>
                    <div class="form-input">
                        <button class="btn btn-blue btn-block">Login</button>
                    </div>
                </div>
                <p> copyright 2021 - all right are reserved &copy;</p>
            </div>
        </div>
    </form>
    <script>
    const error = document.querySelector('.error')
    setTimeout(() => {
        if (error) {
            error.parentNode.removeChild(error);
        }
    }, 3000)
    </script>
</body>

</html>