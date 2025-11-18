<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Facilities</title>
    <link rel="stylesheet" href="adminc/facilities.css">
    <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
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

    <form id="facilityForm">
        <label for="name">Facility Name:</label>
        <input type="text" id="name" name="name" required>
        <button type="submit">Add Facility</button>
    </form>

    <div id="message"></div>

    <h3>Facility List</h3>
    <table id="facilityTable">
        <thead>
            <tr>
                <th>Facility Name</th>
                <th>Action</th>
            </tr>
        </thead>
        <tbody></tbody>
    </table>

    <script>
        function fetchFacilities() {
            $.ajax({
                url: 'ajax-request/ajax-facilities.php',
                type: 'GET',
                dataType: 'json',
                success: function(data) {
                    let tableBody = '';
                    data.forEach(function(facility) {
                        tableBody += `
                            <tr>
                                <td>${facility.name}</td>
                                <td><button class="deleteBtn" data-id="${facility.id}">Delete</button></td>
                            </tr>
                        `;
                    });
                    $('#facilityTable tbody').html(tableBody);
                },
                error: function() {
                    $('#facilityTable tbody').html('<tr><td colspan="2">Failed to load facilities.</td></tr>');
                }
            });
        }

        $('#facilityForm').on('submit', function(e) {
            e.preventDefault();

            $.ajax({
                url: 'ajax-request/ajax-facilities.php',
                type: 'POST',
                data: $(this).serialize(),
                dataType: 'json',
                success: function(response) {
                    $('#message').html(`<span style="color: ${response.status === 'success' ? 'green' : 'red'};">${response.message}</span>`);
                    if (response.status === 'success') {
                        $('#facilityForm')[0].reset();
                        fetchFacilities();
                    }
                    setTimeout(() => $('#message').html(''), 2000);
                },
                error: function() {
                    $('#message').html('<span style="color: red;">AJAX request failed.</span>');
                }
            });
        });

        $('#facilityTable').on('click', '.deleteBtn', function() {
            const facilityId = $(this).data('id');

            if (confirm('Are you sure you want to delete this facility?')) {
                $.ajax({
                    url: 'ajax-request/ajax-facilities.php',
                    type: 'POST',
                    data: { id: facilityId },
                    dataType: 'json',
                    success: function(response) {
                        if (response.status === 'success') {
                            $('#message').html('<span style="color: green;">Facility successfully deleted.</span>');
                            fetchFacilities();
                            setTimeout(() => $('#message').html(''), 3000);
                        } else {
                            $('#message').html(`<span style="color: red;">${response.message}</span>`);
                        }
                    },
                    error: function() {
                        $('#message').html('<span style="color: red;">Failed to delete facility.</span>');
                    }
                });
            }
        });

        $(document).ready(function() {
            fetchFacilities();
        });
    </script>

</body>
</html>
