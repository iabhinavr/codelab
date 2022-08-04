<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Chat</title>
    <link rel="stylesheet" href="style.css">
</head>
<body>

    <div class="container">
        <div class="chat-container">
            <form action="" class="join-form">
                <input type="text" name="name" id="fname" placeholder="Enter name">
                <button type="submit">Join Chat</button>
            </form>
            <form action="" method="post" class="msg-form hidden">
                <input type="text" name="msg" id="msg" placeholder="Write message">
                <button type="submit">Send</button>
            </form>
            <div class="messages">

            </div>
        </div>
    </div>
    
    <script>
        let socket = new WebSocket("ws://codelab.local:8000/phpsock/");

        var socketOpen = (e) => {
            console.log("connected to the socket");
            socket.send("This is me, the browser");
        }

        var socketMessage = (e) => {
            console.log(`Message from socket: ${e.data}`);
            appendMessage(e.data);
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

        function sendMessage(message) {
            socket.send(message);
        }

        function appendMessage(message) {
            
            var parsedMsg;
            var msgContainer = document.querySelector(".messages");
            if (parsedMsg = parseMessage(message)) {
                console.log('appending message');
                console.log(parsedMsg);
                var newMsg = document.createElement("div");
                newMsg.classList.add("msg");
                var nameSpan = document.createElement("span");
                nameSpan.classList.add("msg-name");
                var name = document.createTextNode(parsedMsg.name + ': ');
                nameSpan.appendChild(name);
                var textSpan = document.createElement("span");
                textSpan.classList.add("msg-text");
                var text = document.createTextNode(parsedMsg.text);
                textSpan.appendChild(text);
                newMsg.appendChild(nameSpan);
                newMsg.appendChild(textSpan);
                msgContainer.appendChild(newMsg);
            }
        }

        function parseMessage(message) {
            var msg = {name: "", text: ""};
            try {
                msg = JSON.parse(message);
            }
            catch(e) {
                return false;
            }
            return msg;
        }
        
        var name = '';
        var joinForm = document.querySelector('form.join-form');
        console.log(joinForm);
        var msgForm = document.querySelector('form.msg-form');

        function joinFormSubmit(event) {
            event.preventDefault();
            name = document.getElementById('fname').value;
            sendMessage(name + ' joined the chat!');
            joinForm.classList.add('hidden');
            msgForm.classList.remove('hidden');
        }

        joinForm.addEventListener('submit', joinFormSubmit);

        function msgFormSubmit(event) {
            event.preventDefault();
            var msgText, msg;
            msgText = document.getElementById('msg').value;
            msg = {
                name: name,
                text: msgText
            };
            msg = JSON.stringify(msg);
            sendMessage(msg);
        }

        msgForm.addEventListener('submit', msgFormSubmit);
        
    </script>
    
</body>
</html>