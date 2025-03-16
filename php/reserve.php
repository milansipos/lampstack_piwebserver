<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="../styling/reserve.css">
    <title>Reserving</title>
</head>
<body>
<nav>
    <a href="myreservations.php">My Reservations</a>
    <a href="book.php">Book</a>
    <a href="base.php">Back to base page</a>
</nav>
<h1>This is the reservation page</h1>

    

    <?php 
        session_start();

        echo date("d.m.Y");
    ?>
</body>
</html>