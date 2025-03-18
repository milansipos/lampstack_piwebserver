<?php
include 'session.php';
include 'profilemenu.php';
include 'navbar.php';
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Blogs</title>
    <link rel="stylesheet" href="../styling/blogpage.css">
</head>
<body>
<h1>All blogs are displayed here</h1>

<?php 

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

        echo "<div class='blog-container'>";
        echo "<h2 class='blogtitle'>Want to post something?</h2>";
        echo "<p class='posterusername'>posted by you</p>";
        echo "<p class='posttime'>Posted: anywhere in the near future</p>"; 
        echo "<p class='postcontent'>whatever you want here to stay</p>";
        echo "<button onclick=\"window.location.href='newblog.php'\" class='newblogbutton'>New post</button>";
        echo "</div>";

if ($result->num_rows > 0) {
    while($row = $result->fetch_assoc()) {
        echo "<div class='blog-container'>";
        echo "<h2 class='blogtitle'>" . htmlspecialchars($row['title']) . "</h2>";
        echo "<p class='posterusername'>posted by " . htmlspecialchars($row['username']) . "</p>";
        echo "<p class='posttime'>Posted: " . htmlspecialchars($row['created_at']) . "</p>"; 
        echo "<p class='postcontent'>" . nl2br(htmlspecialchars($row['content'])) . "</p>";
        
        if ($row['created_at'] != $row['updated_at']) {
            echo "<p class='postedit'>(Edited: " . htmlspecialchars($row['updated_at']) . ")</p>";
        }
        echo "</div>";
    }
} else {
    echo "<div class='blog-container'>You haven't posted anything yet!</div>";
}

?>
</body>
</html>