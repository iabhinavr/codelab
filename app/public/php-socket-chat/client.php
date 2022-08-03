<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Chat</title>
</head>
<body>
    <form action="" method="post">
        <input type="text" name="msg" id="msg">
        <button type="submit">Send</button>
    </form>
    
    <script>
        let socket = new WebSocket("ws://codelab.local:8000/phpsock/");

        var socketOpen = (e) => {
            console.log("connected to the socket");
            socket.send("This is me, the browser");
        }

        var socketMessage = (e) => {
            console.log(`Message from socket: ${e.data}`);
        }

        var socketClose = (e) => {
            if(e.wasClean) {
                console.log("The connection closed cleanly");
            }
            else {
                console.log("The connection closed for some reason");
            }
        }
        
        var socketError = (e) => {
            console.log("WebSocket Error");
            console.log(e);
        }

        socket.addEventListener("open", socketOpen);
        socket.addEventListener("message", socketMessage);
        socket.addEventListener("close", socketClose);
        socket.addEventListener("error", socketError);

        
    </script>
    
</body>
</html>