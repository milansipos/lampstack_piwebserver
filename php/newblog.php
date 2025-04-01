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
    <title>Post a new blog</title>
    <link rel="stylesheet" href="../styling/newblog.css">
</head>
<body>
    <h1>What's on your mind?</h1>
    
<?php 

ini_set('display_errors', 1);
error_reporting(E_ALL);

require_once "../ignore/config.php";

    $conn = new mysqli($DB_HOST, $DB_USER, $DB_PASSWORD, $DB_NAME);

if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}
$username = $_SESSION['username'];


if($_SERVER['REQUEST_METHOD'] === "POST") {

    //append new row
    if(isset($_POST['newpost'])) {
        $title = $_POST['title'];
        $content = $_POST['content'];
    
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
            echo "<div class='unsuccesfulinsert'>Something isn't right :/</div>";
        }
    }elseif(isset($_POST['edit'])) {       //post if only the content is changed
        //todo
        $newcont = $_POST['newcontent'];
        $titleconfirm = $_POST['titleconfirm'];
        echo $_POST['title'];

        if($titleconfirm != $_POST['title']) {
            echo "<div class='unsuccesfulinsert'>Something isn't right :/</div>";
        } else {
            $sqlupdate = "UPDATE blogs SET content = ? WHERE username = ? AND title = ? AND created_at = ?";
            $stmt = $conn->prepare($sqlupdate);
            $stmt->bind_param("ssss", $newcont, $_SESSION['username'], $_POST['title'], $_POST['createdat']);
            if($stmt->execute()) {
                echo "<div class='success'>successfully updated</div>";
            } else {
                echo $stmt->error;
            }
            
            $stmt->close();
        }
        
    } elseif(isset($_POST['delete'])) { //delete
        $title = $_POST['title1'];
        $titleconfirm = $_POST['confirmdelete'];
        $createtime = $_POST['createdat1'];
        $username = $_SESSION['username'];
        echo "DEBUG: Deleting where username='$username', title='$title', created_at='$createtime'<br>";
        echo "Deleting...";
        if($title != $titleconfirm) {
            echo "<div class='unsuccesfulinsert'>Something isn't right :/</div>";
        } else {
            $sqldel = "DELETE FROM blogs WHERE username = ? AND title = ? AND created_at = ?";
            $stmt = $conn->prepare($sqldel);
            $stmt->bind_param("sss", $username, $title, $createtime);
    
            if($stmt->execute()) {
                echo "success";
            } else {
                echo $stmt->error;
            }
            $stmt->close();
        }
    }


    
}

$sql2 = "SELECT title, username, content, created_at, updated_at FROM blogs WHERE username = '$username'";
$result = $conn->query($sql2);

echo "<div class='blog-container'>";

        echo "<form method='post'>";
        echo "<input type=\"hidden\" name=\"newpost\">";
        echo "<h2 class='blogtitle'>Want to post something?</h2>";
        echo "<input type=\"text\" class='posttitle' name=\"title\" placeholder=\"What do you want the title to be?\" required>";
        echo "<p class='posterusername'>posted by you</p>";
        echo "<p class='posttime'>Posted: anywhere in the near future</p>"; 
        echo "<input type=\"text\" name=\"content\" class='postcontent1' placeholder=\"Here you can enter your thoughts.\" required> <br>";
        echo "<input type=\"submit\" value=\"Submit\" class='newblogbutton'>";
        echo "</div>";
        echo "</form>";


if($result->num_rows > 0) {
    echo "<div class='alrpost'>What you already posted:</div>";
    while($row = $result->fetch_assoc()) {
        echo "<div class='blog-container'>";
        echo "<h2 class='blogtitle'>" . htmlspecialchars($row['title']) . "</h2>";
        echo "<p class='posterusername'>posted by " . htmlspecialchars($row['username']) . "</p>";
        echo "<p class='posttime'>Posted: " . htmlspecialchars($row['created_at']) . "</p>"; 
        echo "<p class='postcontent'>" . nl2br(htmlspecialchars($row['content'])) . "</p>";
        
        if ($row['created_at'] != $row['updated_at']) {
            echo "<p class='postedit'>(Edited: " . htmlspecialchars($row['updated_at']) . ")</p>";
        }
        echo "<input type='button' value='Edit' onclick='showmenu(\"formi" . $row['title'] . "\")' class='button'>
            <input type='button' value='Delete this post' onclick='showmenu(\"del" . $row['title'] . "\")' class='button'>
            <form method='post' class='form' id='del" . $row['title'] . "'>
                <input type='hidden' name='delete'>
                <input type='text' name='createdat1' value='" . $row['created_at'] . "'class='formhide'>
                <input type='text' name='title1' value='" . $row['title'] . "'class='formhide'>
                <input type='text' name='confirmdelete' placeholder='Enter the title again to confirm!' class='finaltext' required>
                <input type='submit' value='Delete post' class='button'>
            </form>

            <form method='post' class='form' id='formi" . $row['title'] . "'>
                <input type='hidden' name='edit'>
                <input type='text' class=\"auto-grow\" name='newcontent' placeholder=\"Type new content here...\"></textarea>
                <input type='text' name='titleconfirm' placeholder='Enter the title again to confirm!' class='finaltext' required>
                <input type='text' name='createdat' value='" . $row['created_at'] . "'class='formhide'>
                <input type='text' name='title' value='" . $row['title'] . "'class='formhide'>
                <input type='submit' value='Done' class='button'>
            </form>
        </div>

        <style>
            .form {
                display : none;
            }
            .formhide {
                display : none;
            }
        </style>
        <script>
            function showmenu(formId) {
                var button = document.getElementById(formId);
                if(button.style.display === 'block') {
                    button.style.display = 'none';
                } else {
                    button.style.display = 'block';
                }
        }

        </script>
        ";
    }

} else {
    echo "<div>You haven`t posted anything yet!</div>";
}


?>
</body>
</html>