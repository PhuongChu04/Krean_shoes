<!-- Chatbot Widget -->
<div id="chat-widget" class="chat-widget">
    <!-- Chat Icon -->
    <div id="chat-icon" class="chat-icon">
        <span class="icon icon-chat"></span>
    </div>

    <!-- Chat Box -->
    <div id="chat-box" class="chat-box hidden">
        <div class="chat-header">
            <h4>Chat với AI</h4>
            <button id="close-chat" class="close-btn">&times;</button>
        </div>
        <div class="chat-messages" id="chat-messages">
            <!-- Messages will appear here -->
        </div>
        <div class="chat-input">
            <form id="chat-form">
                <input type="text" id="message-input" placeholder="Nhập tin nhắn..." required>
                <button type="submit" class="send-btn">Gửi</button>
            </form>
        </div>
    </div>
</div>

<style>
.chat-widget {
    position: fixed;
    bottom: 20px;
    right: 20px;
    z-index: 1000;
}

.chat-icon {
    width: 60px;
    height: 60px;
    background-color: #007bff;
    border-radius: 50%;
    display: flex;
    align-items: center;
    justify-content: center;
    cursor: pointer;
    box-shadow: 0 4px 8px rgba(0,0,0,0.2);
    transition: background-color 0.3s;
}

.chat-icon:hover {
    background-color: #0056b3;
}

.chat-icon .icon {
    font-size: 24px;
    color: white;
}

.chat-box {
    position: absolute;
    bottom: 80px;
    right: 0;
    width: 350px;
    max-height: 500px;
    background-color: white;
    border-radius: 10px;
    box-shadow: 0 4px 20px rgba(0,0,0,0.3);
    display: flex;
    flex-direction: column;
    overflow: hidden;
}

.chat-box.hidden {
    display: none;
}

.chat-header {
    background-color: #007bff;
    color: white;
    padding: 15px;
    display: flex;
    justify-content: space-between;
    align-items: center;
}

.chat-header h4 {
    margin: 0;
    font-size: 18px;
}

.close-btn {
    background: none;
    border: none;
    color: white;
    font-size: 24px;
    cursor: pointer;
}

.chat-messages {
    flex: 1;
    padding: 15px;
    overflow-y: auto;
    background-color: #f8f9fa;
}

.chat-input {
    padding: 15px;
    border-top: 1px solid #dee2e6;
    background-color: white;
}

#chat-form {
    display: flex;
}

#message-input {
    flex: 1;
    padding: 10px;
    border: 1px solid #dee2e6;
    border-radius: 5px 0 0 5px;
    outline: none;
}

.send-btn {
    padding: 10px 15px;
    background-color: #007bff;
    color: white;
    border: none;
    border-radius: 0 5px 5px 0;
    cursor: pointer;
    transition: background-color 0.3s;
}

.send-btn:hover {
    background-color: #0056b3;
}
</style>

<script>
document.addEventListener('DOMContentLoaded', function() {
    const chatIcon = document.getElementById('chat-icon');
    const chatBox = document.getElementById('chat-box');
    const closeBtn = document.getElementById('close-chat');
    const chatForm = document.getElementById('chat-form');
    const messageInput = document.getElementById('message-input');
    const chatMessages = document.getElementById('chat-messages');

    chatIcon.addEventListener('click', function() {
        chatBox.classList.toggle('hidden');
    });

    closeBtn.addEventListener('click', function() {
        chatBox.classList.add('hidden');
    });

    chatForm.addEventListener('submit', function(e) {
        e.preventDefault();
        const message = messageInput.value.trim();
        if (message) {
            addMessage('user', message);
            messageInput.value = '';
            setTimeout(() => {
                addMessage('ai', 'Xin chào! Tôi là chatbot AI. (Đây là phản hồi mẫu)');
            }, 1000);
        }
    });

    function addMessage(sender, text) {
        const messageDiv = document.createElement('div');
        messageDiv.className = `message ${sender}`;
        messageDiv.textContent = text;
        chatMessages.appendChild(messageDiv);
        chatMessages.scrollTop = chatMessages.scrollHeight;
    }
});
</script>
