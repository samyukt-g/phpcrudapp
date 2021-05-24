<?php
session_start();

$salt = 'XyZzy12*_';
$stored_hash = '1a52e17fa899cf40fb04cfc42e6352f1';
# Password = php123

// FORM VALIDATION
if (isset($_POST['email']) && isset($_POST['pass'])) {
        $email = $_POST['email'];
        $pswrd = $_POST['pass'];
        if (strlen($email) == 0 || strlen($pswrd) == 0) {
                $_SESSION['error'] = "User name and password are required";
        } else {
                if (hash('md5', $salt . $pswrd) != $stored_hash){
                        error_log("Login fail " . $email . " " . hash('md5', $salt . $pswrd)); 
                        $_SESSION['error'] = "Incorrect password";
                }else {
                        error_log("Login success " . $email);
                        $_SESSION['name'] = $email;
                }
        }
        header('Location: login.php');
        return;
}
?>
<!DOCTYPE html>
<html lang="en">

<head>
        <title>Samyukt G- Login.php</title>
</head>

<body>
        <h1>Please Log In</h1>
        <?php
        if (isset($_SESSION['name'])) {
                unset($_POST);
                header('Location: index.php');
                return;
        }
        if (isset($_SESSION['error'])) {
                echo ('<p style="color:red">' . $_SESSION['error'] . '</p>');
                unset($_SESSION['error']);
                unset($_POST);
        }
        ?>
        <form class="container" method="post">
                <label for="email">User name </label>
                <input type="email" name="email" id="email"><br>
                <label for="pswrd">Password </label>
                <input type="password" name="pass" id="pswrd"><br>
                <input type="submit" value="Log In">
                <a href="index.php">Cancel</a>
        </form>
</body>

</html>