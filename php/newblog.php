<?php
include 'session.php';
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Post a new blog</title>
</head>
<body>
    <nav>
    Back to <a href="base.php">base</a>
    <a href="blogpage.php">Blogs</a>
    </nav>
    <h1>What's on your mind?</h1>

    <form method="post">
        <input type="text" name="title" placeholder="What do you want the title to be?">
        <input type="text" name="content" placeholder="Here you can enter your thoughts.">
        <input type="submit" value="Submit">
    </form>


    

<?php 

    echo date("d.m.Y");

require_once "../.gitignore/config.php";
        
$conn = new mysqli($DB_HOST, $DB_USER, $DB_PASSWORD, $DB_NAME);

if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}

if($_SERVER['REQUEST_METHOD'] === "POST") {
    $title = $_POST['title'];
    $content = $_POST['content'];
    $username = $_SESSION['username'];
    echo $username;

    $sql = "INSERT INTO blogs (title, content, username) VALUES (?, ?, ?)";
    $stmt = $conn->prepare($sql);
    $stmt->bind_param("sss", $title, $content, $username);

    if($stmt->execute()) {
        echo "successful :D";
        $_SESSION['newblog'] = "set";
        header("refresh:1; url=blogpage.php");
        exit;
    } else {
        echo $stmt->error;
    }
}


?>
</body>
</html>