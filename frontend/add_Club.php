<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Rollins Club Connector</title>
    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css">
    <style>
        .navbar { margin-bottom: 20px; }
        .search-section, .club-section {
            border: 1px solid #ccc;
            padding: 10px;
            margin-bottom: 20px;
        }
    </style>
</head>
<body>
    <div class="container">
        <h2>Add a New Club</h2>
        <div id="response"></div>
        <button type="button" class="btn btn-success" data-toggle="modal" data-target="#addClubModal">Add Club</button>

        <!-- Modal -->
        <div class="modal fade" id="addClubModal" tabindex="-1" role="dialog" aria-labelledby="addClubModalLabel" aria-hidden="true">
            <div class="modal-dialog" role="document">
                <div class="modal-content">
                    <div class="modal-header">
                        <h5 class="modal-title" id="addClubModalLabel">Add a New Club</h5>
                        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                            <span aria-hidden="true">&times;</span>
                        </button>
                    </div>
                    <form id="addClubForm">
                        <div class="modal-body">
                            <div class="form-group">
                                <label for="newActivityName">Club Name:</label>
                                <input type="text" class="form-control" id="newActivityName" name="newActivityName" required>
                            </div>
                            <div class="form-group">
                                <label for="newDescription">Description:</label>
                                <textarea class="form-control" id="newDescription" name="newDescription" required></textarea>
                            </div>
                        </div>
                        <div class="modal-footer">
                            <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
                            <button type="submit" class="btn btn-primary">Add Club</button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>

    <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.5.1/jquery.min.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/popper.js/1.16.0/umd/popper.min.js"></script>
    <script src="https://maxcdn.bootstrapcdn.com/bootstrap/4.5.2/js/bootstrap.min.js"></script>
    <script>
    $(document).ready(function() {
        // Submit form using AJAX when Add Club button is clicked.
        $("#addClubForm").submit(function(event) {
            event.preventDefault(); // Prevent default form submission.

            // Serialize form data.
            var formData = $(this).serialize();

            // Submit form data using AJAX.
            $.ajax({
                type: "POST",
                url: "add_club.php",
                data: formData,
                success: function(response) {
                    // Display the response message.
                    $("#response").html("<div class='alert alert-success'>" + response + "</div>");
                    // Clear the form fields after successful submission.
                    $("#addClubForm")[0].reset();
                    // Close the modal after successful submission.
                    $('#addClubModal').modal('hide');
                },
                error: function(xhr, status, error) {
                    // Display error message if AJAX request fails.
                    $("#response").html("<div class='alert alert-danger'>Error: " + xhr.responseText + "</div>");
                }
            });
        });
    });
    </script>
</body>
</html>
