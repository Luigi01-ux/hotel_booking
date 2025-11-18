<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Add Room</title>
    <link rel="stylesheet" href="adminc/rooms.css">
</head>
<body>

    <a href="index.php" class="btn-back">← Back</a>

<style>
.btn-back {
  display: inline-block;
  background-color: #007BFF; /* blue */
  color: white;
  padding: 10px 20px;
  text-decoration: none;
  border-radius: 5px;
  font-family: sans-serif;
  transition: background-color 0.2s;
}

.btn-back:hover {
  background-color: #0056b3;
}
</style>

    <h3>Add Room</h3>
    <form id="roomForm" enctype="multipart/form-data">
        <label for="name">Room Name:</label>
        <input type="text" id="name" name="name" required><br><br>

        <label for="photo_path">Room Photo:</label>
        <input type="file" id="photo_path" name="photo_path" required><br><br>

        <label for="description">Room Description:</label>
        <textarea id="description" name="description" required></textarea><br><br>

        <label for="price">Price per night:</label>
        <input type="number" id="price" name="price" step="0.01" min="0" required><br><br>


        <label for="status_id">Room Status:</label>
        <select id="status_id" name="status_id" required>
            <option value="1">Available</option>
            <option value="0">Not Available</option>
        </select><br><br>


        <h4>Select Features</h4>
        <div id="featuresContainer"></div>

        <h4>Select Facilities</h4>
        <div id="facilitiesContainer"></div>

        <button type="submit">Add Room</button>
    </form>

    <div id="message" style="margin-top: 10px;"></div>

    <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
    <script>
        // Fetch features and facilities for the checkboxes
        function fetchOptions() {
            $.ajax({
                url: 'ajax-request/ajax-features.php',
                type: 'GET',
                dataType: 'json',
                success: function(data) {
                    let featureHtml = '';
                    data.forEach(function(feature) {
                        featureHtml += `
                            <label><input type="checkbox" name="features[]" value="${feature.id}"> ${feature.name}</label><br>
                        `;
                    });
                    $('#featuresContainer').html(featureHtml);
                },
                error: function() {
                    $('#message').html('<span style="color: red;">Failed to load features.</span>');
                }
            });

            $.ajax({
                url: 'ajax-request/ajax-facilities.php',
                type: 'GET',
                dataType: 'json',
                success: function(data) {
                    let facilityHtml = '';
                    data.forEach(function(facility) {
                        facilityHtml += `
                            <label><input type="checkbox" name="facilities[]" value="${facility.id}"> ${facility.name}</label><br>
                        `;
                    });
                    $('#facilitiesContainer').html(facilityHtml);
                },
                error: function() {
                    $('#message').html('<span style="color: red;">Failed to load facilities.</span>');
                }
            });
        }

        // Submit the room form
        $('#roomForm').on('submit', function(e) {
            e.preventDefault();

            let formData = new FormData(this); // to handle file uploads
            $.ajax({
                url: 'ajax-request/ajax-rooms.php',
                type: 'POST',
                data: formData,
                processData: false, // to prevent jQuery from processing the data
                contentType: false, // to ensure the proper content type is sent for file uploads
                dataType: 'json',
                success: function(response) {
                    $('#message').html(`<span style="color: ${response.status === 'success' ? 'green' : 'red'};">${response.message}</span>`);
                    if (response.status === 'success') {
                        $('#roomForm')[0].reset();
                        fetchOptions(); // Reload features and facilities
                    }
                    setTimeout(() => $('#message').html(''), 3000);
                },
                error: function() {
                    $('#message').html('<span style="color: red;">AJAX request failed.</span>');
                }
            });
        });

        // Initial fetch of features and facilities
        $(document).ready(function() {
            fetchOptions();
        });
    </script>
</body>
</html>
