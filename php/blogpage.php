<?php
include 'session.php';
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Blogs</title>
</head>
<body>
    <nav>
        Back to base page <a href="base.php">here</a>
        Want to create a new post? Click <a href="newblog.php">here</a>
    </nav>

<h1>All blogs are displayed here</h1>
    

<?php 

echo date("d.m.Y");

require_once "../.gitignore/config.php";
        
$conn = new mysqli($DB_HOST, $DB_USER, $DB_PASSWORD, $DB_NAME);

if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}

    if(isset($_SESSION['newblog'])) {
        echo "<div>New blog successfully created!</div>";
        $_SESSION['newblog'] = null;
    }

$sql = "SELECT title, username, content, created_at, updated_at, username FROM blogs";
$result = $conn->query($sql);

if ($result->num_rows > 0) {
    while($row = $result->fetch_assoc()) {
        echo "<h2>" . $row['title'] . "</h2> <p>posted by " . $row['username'] . "<br>";
        echo "<p>Posted: " . $row['created_at'] . "</p>"; 
        echo "<p>" . $row['content'] . "</p>";
        if($row['created at'] != $row['updated_at']) {
            echo "<p>(Edited: " . $row['updated_at'] . ")</p>";
        }
    }
} else {
    echo "no blogs posted yet :P";
}





?>
</body>
</html>