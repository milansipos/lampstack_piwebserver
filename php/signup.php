<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="../styling/signup.css">
    <title>Sign up</title>
</head>
<body>

    <div class = signupbox>
        <h1>Create an account!</h1>
        <form method="post" class="signupform">
            <input type="text" name="username" placeholder="Your Username" class="signuptext" required> <br>
            <input type="text" name="email" placeholder="Your Email (example@example.com)" class="signuptext" required> <br>
            <input type="password" name="password" placeholder="Enter your password" class="signuptext" required> <br>
            <input type="password" name="2ndpassword" placeholder="Enter your password again" class="signuptext" required> <br>
            <input type="submit" Value="Sign up" class="signupsubmit">
        </form>

    <h3>Or if you have already, you can sign in <a href="login.php" class="logintext">here.</a></h3>

    <?php
    
    require_once "../.gitignore/config.php";

    $conn = new mysqli($DB_HOST, $DB_USER, $DB_PASSWORD, $DB_NAME);

    if($conn->error) {
        echo "Connection error";
        exit;
    }

    if($_SERVER['REQUEST_METHOD'] === "POST") {

        $username = $_POST['username'];
        $email = $_POST['email'];
        $password = $_POST['password'];
        $secondpassw = $_POST['2ndpassword'];

        if($password != $secondpassw) {
            echo "Passwords dont match!";
            exit;
        }

        $password_hash = password_hash($password, PASSWORD_DEFAULT);
        
        $sql = "INSERT INTO logins (username, email, password_hash) VALUES (?, ?, ?)";
        $stmt = $conn->prepare($sql);
        $stmt->bind_param("sss", $username, $email, $password_hash);

        if($stmt->execute()) {
            echo "<div class='redirection'>User registered succesfully</div>";
            header("refresh:2; url=login.php");
            echo "<div class='redirection'>You are being redirected to the login page. If not, click <a href='login.php' class='logintextnew'>HERE</a></div>";
            exit;
        } else {
            echo "<div class='redirection'>Error: " . $stmt->error . "</div>";
        }
    }

    $stmt->close();
    $conn->close();

    ?>

    </div>

</body>
</html>