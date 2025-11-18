<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Inbox</title>
    <link rel="stylesheet" href="adminc/messages.css">
</head>
<body>
    <h2>Inbox</h2>

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

    <div style="display: flex;">
        <div style="width: 200px;" id="subject-list"></div>
        <div style="flex: 1;" class="message-box" id="message-content">
            <p>Select a message to view its content.</p>
        </div>
    </div>

    <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
    <script>
        // Fetch message subjects on page load
        $(document).ready(function() {
            $.get('ajax-request/ajax_fetch_messages.php', function(data) {
                const messages = JSON.parse(data);
                let html = '';
                messages.forEach((msg, index) => {
                    html += `<div class="tab" data-id="${msg.id}">${msg.subject}</div>`;
                });
                $('#subject-list').html(html);
            });

            // Click event to load full message
            $('#subject-list').on('click', '.tab', function() {
                $('.tab').removeClass('active-tab');
                $(this).addClass('active-tab');

                const id = $(this).data('id');
                $.get('ajax-request/ajax_fetch_message.php', { id: id }, function(data) {
                    const msg = JSON.parse(data);
                    $('#message-content').html(`
                        <h4>${msg.subject}</h4>
                        <p><strong>From:</strong> ${msg.name}</p>
                        <p>${msg.message}</p>
                    `);
                });
            });
        });
    </script>
</body>
</html>
