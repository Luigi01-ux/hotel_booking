<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Add Feature</title>
    <link rel="stylesheet" href="adminc/features.css">
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


<style>
.btn {
  display: inline-block;
  background-color: #007BFF; /* blue button */
  color: white;
  padding: 10px 16px;
  border-radius: 5px;
  text-decoration: none;
  font-family: sans-serif;
  font-size: 14px;
  transition: background-color 0.3s ease;
}

.btn:hover {
  background-color: #0056b3; /* darker blue on hover */
}
</style>

    <form id="featureForm">
        <label for="name">Feature Name:</label>
        <input type="text" id="name" name="name" required>
        <button type="submit">Add Feature</button>
    </form>

    <div id="message"></div>

    <h3>Feature List</h3>
    <table id="featureTable">
        <thead>
            <tr>
                <th>Feature Name</th>
                <th>Action</th>
            </tr>
        </thead>
        <tbody></tbody>
    </table>

        <script>
    function fetchFeatures() {
        $.ajax({
            url: 'ajax-request/ajax-features.php',
            type: 'GET',
            dataType: 'json',
            success: function(data) {
                let tableBody = '';
                data.forEach(function(feature) {
                    tableBody += `
                        <tr>
                            <td>${feature.name}</td>
                            <td><button class="deleteBtn" data-id="${feature.id}">Delete</button></td>
                        </tr>
                    `;
                });
                $('#featureTable tbody').html(tableBody);
            },
            error: function() {
                $('#featureTable tbody').html('<tr><td colspan="2">Failed to load features.</td></tr>');
            }
        });
    }

    $('#featureForm').on('submit', function(e) {
        e.preventDefault();

        $.ajax({
            url: 'ajax-request/ajax-features.php',
            type: 'POST',
            data: $(this).serialize(),
            dataType: 'json',
            success: function(response) {
                $('#message').html(`<span style="color: ${response.status === 'success' ? 'green' : 'red'};">${response.message}</span>`);
                if (response.status === 'success') {
                    $('#featureForm')[0].reset();
                    fetchFeatures();
                }
                setTimeout(() => $('#message').html(''), 2000);
            },
            error: function() {
                $('#message').html('<span style="color: red;">AJAX request failed.</span>');
            }
        });
    });

    $('#featureTable').on('click', '.deleteBtn', function() {
        const featureId = $(this).data('id');

        if (confirm('Are you sure you want to delete this feature?')) {
            $.ajax({
                url: 'ajax-request/ajax-features.php',
                type: 'POST',
                data: { id: featureId },
                dataType: 'json',
                success: function(response) {
                    if (response.status === 'success') {
                        $('#message').html('<span style="color: green;">Feature successfully deleted.</span>');
                        fetchFeatures();
                        setTimeout(() => $('#message').html(''), 3000);
                    } else {
                        $('#message').html(`<span style="color: red;">${response.message}</span>`);
                    }
                },
                error: function() {
                    $('#message').html('<span style="color: red;">Failed to delete feature.</span>');
                }
            });
        }
    });

    $(document).ready(function() {
        fetchFeatures();
    });
</script>



</body>
</html>
