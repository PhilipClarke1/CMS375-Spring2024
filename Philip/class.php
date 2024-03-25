<!DOCTYPE html>
<html>
<head>
    <title>Test Input</title>
</head>
<body style="text-align:center;">

<form method="post">
    <input type="text" name="user_input" placeholder="Enter something...">
    <input type="submit" name="submit_button" value="Submit"/>
</form>

<?php
if (isset($_POST['submit_button'])) {
    $userInput = isset($_POST['user_input']) ? $_POST['user_input'] : '';
    echo "" . htmlspecialchars($userInput);
}
?>

<h1 style="color:green;">
    Bonus Quiz
</h1>

<form action="secondpage.php" method="get">
    <input type="hidden" name="name" id="nameInput" value="MyName">
    <input type="submit" value="Go!">
    
<!-- <img src="moster.jpeg" alt="phil"> -->

</body>
</html>
