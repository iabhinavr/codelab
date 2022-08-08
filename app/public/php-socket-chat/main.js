(function(){
    function sendMessage(message) {
        socket.send(message);
    }

    function parseMessage(message) {
        var msg = {sender: "", text: ""};
        try {
            msg = JSON.parse(message);
        }
        catch(e) {
            return false;
        }
        return msg;
    }

    function appendMessage(message) {
        
        var parsedMsg;
        var msgContainer = document.querySelector(".messages");
        if (parsedMsg = parseMessage(message)) {
            console.log('appending message');
            console.log(parsedMsg);

            var msgElem, senderElem, textElem;
            var sender, text;

            msgElem = document.createElement("div");
            msgElem.classList.add('msg');
            msgElem.classList.add('msg-' + parsedMsg.type);

            senderElem = document.createElement("span");
            senderElem.classList.add("msg-sender");

            textElem = document.createElement("span");
            textElem.classList.add("msg-text");

            sender = document.createTextNode(parsedMsg.sender + ': ');
            text = document.createTextNode(parsedMsg.text);

            console.log(sender);
            
            senderElem.appendChild(sender);
            textElem.appendChild(text);

            msgElem.appendChild(senderElem);
            msgElem.appendChild(textElem);

            msgContainer.appendChild(msgElem);
        }
    }

    function setup() {
        var sender = '';
        var joinForm = document.querySelector('form.join-form');
        console.log(joinForm);
        var msgForm = document.querySelector('form.msg-form');
    
        function joinFormSubmit(event) {
            event.preventDefault();
            sender = document.getElementById('sender').value;
            var joinMsg = {
                type: "join",
                sender: sender,
                text: sender + ' joined the chat!'
            };
            sendMessage(JSON.stringify(joinMsg));
            joinForm.classList.add('hidden');
            msgForm.classList.remove('hidden');
        }
    
        joinForm.addEventListener('submit', joinFormSubmit);
    
        function msgFormSubmit(event) {
            event.preventDefault();
            var msgField, msgText, msg;
            msgField = document.getElementById('msg');
            msgText = msgField.value;
            msg = {
                type: "normal",
                sender: sender,
                text: msgText
            };
            msg = JSON.stringify(msg);
            sendMessage(msg);
            msgField.value = '';
        }
    
        msgForm.addEventListener('submit', msgFormSubmit);
    }

    let socket = new WebSocket("ws://codelab.local:8000/phpsock/");

    var socketOpen = (e) => {
        console.log("connected to the socket");
        var msg = {
            type: 'join',
            sender: 'Browser',
            text: 'connected to the chat server'
        }
        appendMessage(JSON.stringify(msg));
        setup();
    }

    var socketMessage = (e) => {
        console.log(`Message from socket: ${e.data}`);
        appendMessage(e.data);
    }

    var socketClose = (e) => {
        var msg;
        if(e.wasClean) {
            console.log("The connection closed cleanly");
            msg = {
                type: 'left',
                sender: 'Browser',
                text: 'The connection closed cleanly'
            }
        }
        else {
            console.log("The connection closed for some reason");
            var msg = {
                type: 'left',
                sender: 'Browser',
                text: 'The connection closed for some reason'
            }
        }
        appendMessage(JSON.stringify(msg));
    }
    
    var socketError = (e) => {
        console.log("WebSocket Error");
        console.log(e);
    }

    socket.addEventListener("open", socketOpen);
    socket.addEventListener("message", socketMessage);
    socket.addEventListener("close", socketClose);
    socket.addEventListener("error", socketError);
   
})();