<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Testing HTML</title>
</head>
<body style="text-align:center;">

    <h1 style="color:green;">Test Code</h1>

    <label for="answer">Type Something:</label>
    <input type="text" id="answer" name="answer" placeholder="Type here...">
    <button onclick="displayText()">Display Text</button>
    <p id="display-text"></p>

    <script>
        function displayText() {
            var userInput = document.getElementById("answer").value;
            if (userInput.toLowerCase() === "trevor") {
                // If user input is "Trevor", load content from "trevor.php"
                fetch("trevor.php")
                    .then(response => response.text())
                    .then(data => {
                        document.getElementById("display-text").innerText = data;
                    })
                    .catch(error => {
                        console.error("Error fetching data:", error);
                    });
            } else {
                // Display user input if it's not "Trevor"
                document.getElementById("display-text").innerText = "You typed: " + userInput;
            }
        }
    </script>

</body>
</html>
