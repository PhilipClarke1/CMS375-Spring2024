<!DOCTYPE html>
<html>
    <head>
        <title>
            Test ?
        </title>
        <meta charset="UTF-8">
    <title>Text Display</title>
    <script>
    function displayText() {
        // Get the value from the textbox
        var text = document.getElementById('inputText').value;
        // Display the text in the div above
        document.getElementById('displayText').innerHTML = text;    
    }
</script>

<body style = "text-align:center;">
    <?php
    if(array_key_exists('button', $_POST))
        button();
    else
        button2();

    function button(){
        echo 'legal';
    }

    function button2(){
        echo 'illegal';
    }
    ?>

    <form method='post'>
        <input type = "submit" name = "button"
        class="button" value = "W"/>
    </form>

    <form method='post'>
        <input type="submit" name = "button2"
        class="button" value = "L"/>
    </form>

    <h1 style="color:green;">
        Test code
    </h1>

    <?php
        echo "Hello, Trevor!";
    ?>
    <img src="elephant.png" alt="phil">

    <div id="displayText"></div> <!-- The text will appear here -->
    <input type="text" id="inputText" placeholder="Type something...">
    <button onclick="displayText()">Display Text</button>
    <form action="Brandon.php" method="get">
    <input type="hidden" name="name" id="nameInput" value="MyName"> <!-- Replace 'MyName' with the actual name you want to pass -->
    <input type="submit" value="Go!">
</form>

</body>
</html>