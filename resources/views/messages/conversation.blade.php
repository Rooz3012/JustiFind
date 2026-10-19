@include('layouts.header')

<style>
    .chat-wrapper { max-width: 800px; margin: 0 auto; }
    .chat-container {
        background: var(--card-bg);
        border: 1px solid var(--border);
        border-radius: 24px;
        overflow: hidden;
        box-shadow: 0 20px 60px rgba(0,0,0,0.3);
    }
    .chat-header {
        background: linear-gradient(135deg, var(--dark2), var(--dark3));
        border-bottom: 1px solid var(--border);
        padding: 1.3rem 1.5rem;
        display: flex; align-items: center; gap: 1rem;
    }
    .chat-avatar {
        width: 46px; height: 46px;
        background: linear-gradient(135deg, var(--primary), var(--primary-dark));
        border-radius: 14px;
        display: flex; align-items: center; justify-content: center;
        font-size: 1.2rem; font-weight: 800; color: var(--dark); flex-shrink: 0;
        animation: pulse-gold 3s ease-in-out infinite;
    }
    .chat-header-info h4 { font-weight: 700; color: var(--text); font-size: 1rem; }
    .chat-header-info p { font-size: 0.78rem; color: var(--text-muted); margin-top: 0.2rem; }
    .online-dot {
        width: 8px; height: 8px; background: #3fb950;
        border-radius: 50%; display: inline-block; margin-right: 4px;
        box-shadow: 0 0 6px #3fb950;
    }
    .chat-messages {
        padding: 1.5rem; max-height: 450px; overflow-y: auto;
        display: flex; flex-direction: column; gap: 1rem;
        background: var(--body-bg);
    }
    .message-bubble { max-width: 72%; display: flex; flex-direction: column; }
    .message-bubble.sent { align-self: flex-end; align-items: flex-end; }
    .message-bubble.received { align-self: flex-start; align-items: flex-start; }
    .bubble-content {
        padding: 0.85rem 1.2rem; border-radius: 18px;
        font-size: 0.9rem; line-height: 1.6; word-wrap: break-word;
        animation: scaleIn 0.2s ease;
    }
    .sent .bubble-content {
        background: linear-gradient(135deg, var(--primary), var(--primary-dark));
        color: var(--dark); border-bottom-right-radius: 4px; font-weight: 500;
    }
    .received .bubble-content {
        background: var(--dark3); color: var(--text);
        border: 1px solid var(--border); border-bottom-left-radius: 4px;
    }
    .bubble-meta { font-size: 0.72rem; color: var(--text-muted); margin-top: 0.3rem; padding: 0 0.3rem; }
    .empty-chat { text-align: center; padding: 3rem; color: var(--text-muted); }
    .empty-chat-icon { font-size: 3rem; margin-bottom: 0.8rem; opacity: 0.4; animation: float 3s ease-in-out infinite; }
    .chat-input-area {
        padding: 1.2rem 1.5rem;
        border-top: 1px solid var(--border); background: var(--dark2);
    }
    .chat-input-row { display: flex; gap: 0.8rem; align-items: center; }
    .chat-input {
        flex: 1; padding: 0.85rem 1.2rem;
        background: var(--dark3); border: 1px solid var(--border);
        border-radius: 25px; font-size: 0.9rem; font-family: inherit; color: var(--text);
        transition: all 0.2s;
    }
    .chat-input:focus { outline: none; border-color: var(--primary); box-shadow: 0 0 0 3px rgba(201,168,76,0.1); }
    .chat-input::placeholder { color: var(--text-muted); }
    .send-btn {
        width: 46px; height: 46px; border-radius: 50%;
        background: linear-gradient(135deg, var(--primary), var(--primary-dark));
        border: none; cursor: pointer;
        display: flex; align-items: center; justify-content: center;
        font-size: 1.1rem; flex-shrink: 0; transition: all 0.2s; color: var(--dark);
    }
    .send-btn:hover { transform: scale(1.1) rotate(10deg); box-shadow: 0 4px 15px rgba(201,168,76,0.4); }
    .typing-indicator {
        display: none; align-self: flex-start;
        background: var(--dark3); border: 1px solid var(--border);
        border-radius: 18px; padding: 0.6rem 1rem;
        font-size: 0.8rem; color: var(--text-muted);
    }
    .typing-indicator.show { display: flex; align-items: center; gap: 0.5rem; }
    .typing-dot {
        width: 6px; height: 6px; background: var(--primary);
        border-radius: 50%; animation: float 0.6s ease-in-out infinite;
    }
    .typing-dot:nth-child(2) { animation-delay: 0.2s; }
    .typing-dot:nth-child(3) { animation-delay: 0.4s; }
</style>

<div class="chat-wrapper">
    <a href="http://localhost/justifind/public/messages" class="back-link">← Back to Messages</a>

    <div class="chat-container">
        <div class="chat-header">
            <div class="chat-avatar">{{ strtoupper(substr($otherName, 0, 1)) }}</div>
            <div class="chat-header-info">
                <h4>{{ $otherName }}</h4>
                <p>
                    <span class="online-dot"></span>
                    Consultation #{{ $consultationId }} · {{ $consultation->Type }}
                </p>
            </div>
        </div>

        <div class="chat-messages" id="chatMessages">
            @forelse($messages as $msg)
            @php $isSent = $msg->sender_id == $userId && $msg->sender_type == $role; @endphp
            <div class="message-bubble {{ $isSent ? 'sent' : 'received' }}" id="msg-{{ $msg->id }}">
                <div class="bubble-content">{{ $msg->message }}</div>
                <div class="bubble-meta">
                    {{ $isSent ? 'You' : $otherName }} ·
                    {{ date('M d, h:i A', strtotime($msg->created_at)) }}
                </div>
            </div>
            @empty
            <div class="empty-chat">
                <div class="empty-chat-icon">👋</div>
                <p>No messages yet. Say hello!</p>
            </div>
            @endforelse
            <div class="typing-indicator" id="typingIndicator">
                <span>{{ $otherName }} is typing</span>
                <div class="typing-dot"></div>
                <div class="typing-dot"></div>
                <div class="typing-dot"></div>
            </div>
        </div>

        <div class="chat-input-area">
            <form action="http://localhost/justifind/public/messages/send" method="POST" id="messageForm">
                @csrf
                <input type="hidden" name="consultation_id" value="{{ $consultationId }}">
                <input type="hidden" name="receiver_id" value="{{ $otherId }}">
                <input type="hidden" name="receiver_type" value="{{ $otherType }}">
                <div class="chat-input-row">
                    <input type="text" name="message" id="messageInput"
                        class="chat-input" placeholder="Type your message..."
                        autocomplete="off" required>
                    <button type="submit" class="send-btn">📤</button>
                </div>
            </form>
        </div>
    </div>
</div>

<script src="https://js.pusher.com/8.2.0/pusher.min.js"></script>
<script>
    const chatMessages = document.getElementById('chatMessages');
    if (chatMessages) chatMessages.scrollTop = chatMessages.scrollHeight;

    const pusher = new Pusher('{{ $pusherKey }}', {
        cluster: '{{ $pusherCluster }}',
        useTLS: true
    });

    const channel = pusher.subscribe('chat-{{ $consultationId }}');

    channel.bind('new-message', function(data) {
        if (data.sender_id == {{ $userId }} && data.sender_type == '{{ $role }}') return;

        const emptyChat = document.querySelector('.empty-chat');
        if (emptyChat) emptyChat.remove();

        const bubble = document.createElement('div');
        bubble.className = 'message-bubble received';
        bubble.id = 'msg-' + data.id;
        bubble.innerHTML = `
            <div class="bubble-content">${escapeHtml(data.message)}</div>
            <div class="bubble-meta">${escapeHtml(data.sender_name)} · ${data.created_at}</div>
        `;

        const typing = document.getElementById('typingIndicator');
        chatMessages.insertBefore(bubble, typing);

        bubble.style.opacity = '0';
        bubble.style.transform = 'translateY(10px)';
        setTimeout(() => {
            bubble.style.transition = 'all 0.3s ease';
            bubble.style.opacity = '1';
            bubble.style.transform = 'translateY(0)';
        }, 50);

        chatMessages.scrollTop = chatMessages.scrollHeight;
        document.getElementById('typingIndicator').classList.remove('show');
    });

    let typingTimer;
    const messageInput = document.getElementById('messageInput');

    messageInput.addEventListener('input', function() {
        clearTimeout(typingTimer);
        typingTimer = setTimeout(() => {}, 2000);
    });

    channel.bind('client-typing', function(data) {
        if (data.userId != {{ $userId }}) {
            const indicator = document.getElementById('typingIndicator');
            indicator.classList.add('show');
            chatMessages.scrollTop = chatMessages.scrollHeight;
            clearTimeout(window.typingTimeout);
            window.typingTimeout = setTimeout(() => {
                indicator.classList.remove('show');
            }, 2000);
        }
    });

    function escapeHtml(text) {
        const div = document.createElement('div');
        div.appendChild(document.createTextNode(text));
        return div.innerHTML;
    }

    // Also handle form submit to show message immediately
    document.getElementById('messageForm').addEventListener('submit', function(e) {
        const input = document.getElementById('messageInput');
        const text = input.value.trim();
        if (!text) return;

        const emptyChat = document.querySelector('.empty-chat');
        if (emptyChat) emptyChat.remove();

        const bubble = document.createElement('div');
        bubble.className = 'message-bubble sent';
        bubble.innerHTML = `
            <div class="bubble-content">${escapeHtml(text)}</div>
            <div class="bubble-meta">You · Just now</div>
        `;

        const typing = document.getElementById('typingIndicator');
        chatMessages.insertBefore(bubble, typing);
        chatMessages.scrollTop = chatMessages.scrollHeight;
    });
</script>

@include('layouts.footer')