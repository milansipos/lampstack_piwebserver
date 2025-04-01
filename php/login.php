<?php 
    session_start();
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Login Page</title>
    <link rel="stylesheet" href="../styling/login.css">
</head>
<body>

    <div class="loginbox">
        <h1>Please sign in.</h1>

        <form method="post">
            <input type="text" name="username" placeholder="Username" class="logintext" required> <br>
            <input type="password" name="password" placeholder="Your password" class="logintext" required> <br>
            <input type="submit" Value="Login" class="loginbutton">
        </form> 

        <h3>Or if you haven't yet, you can sign up <a href="signup.php" class="signuptext">here.</a></h3>

        <?php 

    // setcookie('test_cookie', 'test_value', time() + 3600, '/');
    // if (isset($_COOKIE['test_cookie'])) {
    //     #echo "Cookies are working!";
    // } else {
    //     #echo "Cookies are not working!";
    // }


    require_once "../ignore/config.php";

    $conn = new mysqli($DB_HOST, $DB_USER, $DB_PASSWORD, $DB_NAME);
    //$conn = new mysqli('db', 'user', 'userpassword', 'lamp_db');
    
    if($conn->connect_error) {
        echo "connection failed";
        exit;
    }

    if($_SERVER['REQUEST_METHOD'] === "POST") {

    $username = $_POST['username'];
    $password = $_POST['password'];

    $sql = "SELECT id, username, password_hash FROM logins WHERE username = ?";
    $stmt = $conn->prepare($sql);
    $stmt->bind_param("s", $username);
    $stmt->execute();
    $result = $stmt->get_result();

    if($result->num_rows > 0) {
        $user = $result->fetch_assoc();
        #var_dump($user);
        if(password_verify($password, $user['password_hash'])) {
            $_SESSION['userid'] = $user['id'];
            $_SESSION['username'] = $user['username'];

            header("refresh:0.2; url=base.php");
            #var_dump($_SESSION);
            echo "<div class='redirectionsuccesful'>You are being redirected to base, if not click <a href='base.php' class='signuptextnew'>here</a></div>";
            exit();
        } else {
            echo "<div class='redirectionfail'>False Credentials</div>";
        }
    } else {
        echo "<div class='redirectionfail'>No such User.</div>";
    }
}

    $stmt->close();
    $conn->close();

?>
    </div>
</body>
</html>

