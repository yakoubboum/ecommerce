<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Chat App</title>
    <script src="https://code.jquery.com/jquery-3.6.0.min.js"
        integrity="sha256-/xUj+3OJU5yExlq6GSYGSHk7tPXikynS7ogEvDej/m4=" crossorigin="anonymous"></script>
    <script src="https://js.pusher.com/7.0/pusher.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/ntp-time@0.3.3/dist/ntp-time.min.js"></script>

    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@5.1.3/dist/css/bootstrap.min.css"
        integrity="sha384-1BmE4kWBq78iYhFldvKuhfTAU6auU8tT94WrHftjDbrCEXSU1oBoqyl2QvZ6jIW3" crossorigin="anonymous">
    <style>
        .chat-container {
            border: 1px solid #ddd;
            padding: 10px;
            height: 400px;
            overflow-y: scroll;
        }

        .message {
            margin-bottom: 10px;
            padding: 10px;
            border-radius: 5px;
            background-color: #eee;
        }

        .message.self {
            background-color: #ddd;
            text-align: right;
        }
    </style>
</head>

<body>
    <div class="container">
        <div class="chat-container">
            <ul id="messages"></ul>
        </div>
        <form id="chat-form">
            @csrf
            <input type="hidden" name="user_id" id="user_id" value="{{ $receiver->id }}">
            <div class="form-group">
                <textarea name="message" id="message" class="form-control" rows="3" placeholder="Type your message here..."></textarea>
            </div>
            <button type="submit" class="btn btn-primary">Send</button>
        </form>
    </div>

    <script>
        // Pusher configuration
        var pusher = new Pusher('{{ env('PUSHER_APP_KEY') }}', {
            cluster: '{{ env('PUSHER_APP_CLUSTER') }}',
            encrypted: true
        });

        // Private channel for chat with the recipient
        var channel = pusher.subscribe('chat.{{ $receiver->id }}'); // Dynamic channel name based on recipient ID

        // Listen for received messages
        channel.bind('message-sent', function(data) {
            var message = data.message;
            var message_html = '<li class="message">' + message + '</li>';
            if (message.receiver_id === '{{ Auth::user()->id }}') {
                message_html = '<li class="message self">' + message + '</li>'; // Style messages sent by the user
            }
            $('#messages').append(message_html);
        });

        // Submit message form
        $('#chat-form').submit(function(e) {
            e.preventDefault();

            $.ajax({
                url: '{{ route('chat.sendMessage', $receiver->id) }}', // Route with dynamic parameter
                type: 'POST',
                data: $(this).serialize(),
                success: function(data) {
                    $('#message').val(''); // Clear message input
                    console.log(data); // Log success message for debugging
                },
                error: function(error) {
                    console.error(error);
                }
            });
        });
    </script>

    <script>
        (async () => {
            try {
                // Fetch server time
                const serverTime = await ntpTime.get();

                // Use the synchronized time for your Pusher authorization
                const timestamp = Math.floor(serverTime.getTime() / 1000);
                // ... (rest of your Pusher logic)
            } catch (error) {
                console.error("Error fetching server time:", error);
            }
        })();
    </script>
</body>

</html>
