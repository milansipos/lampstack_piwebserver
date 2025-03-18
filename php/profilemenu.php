<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="../styling/profmenu.css">
    <script src="../app/profmenu.js"></script>
</head>
<body>

    <div class="box">
        <?php
            echo "<div class='profiletop' onclick=\"menu_appear()\" >" . $_SESSION['username'] . "</div>";
        ?>
        
        <div class="menu" id="menu">
            <div class="menupoint" onclick="window.href.location='profile.php'">Profile</div>
            <div class="menupoint onclick="window.href.location='profile.php'"">Settings</div>
            <form method="post">
                <input type="submit" name="logout" value="Log Out" class="menupoint" id="logoutbutton">
            </form>
        </div>
    </div>
    

    <?php
    if($_SERVER["REQUEST_METHOD"] === "POST") {

            if(isset($_POST['logout'])) {
                header("refresh:0.2;url=login.php");
                session_destroy();
                session_unset();
                exit;
            }
    }
    ?>
</body>
</html>