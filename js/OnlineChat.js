document.getElementById("input").addEventListener("keydown", function (e) {
  if (e.key === "Enter") send();
});

function getTime() {
  const d = new Date();
  return (
    d.getHours().toString().padStart(2, "0") +
    ":" +
    d.getMinutes().toString().padStart(2, "0")
  );
}

function send() {
  const input = document.getElementById("input");
  const text = input.value.trim();
  if (!text) return;

  const messages = document.getElementById("messages");

  // USER MESSAGE
  messages.innerHTML += `
    <div class="user-message">
      ${text}
      <div class="time">${getTime()}</div>
    </div>
  `;

  input.value = "";
  messages.scrollTop = messages.scrollHeight;

  // TYPING (3 dots)
  const typingId = "typing-" + Date.now();
  messages.innerHTML += `
    <div class="ai-message typing" id="${typingId}">
      <span></span><span></span><span></span>
    </div>
  `;
  messages.scrollTop = messages.scrollHeight;

  fetch("", {
    method: "POST",
    headers: {
      "Content-Type": "application/x-www-form-urlencoded",
    },
    body: `message=${encodeURIComponent(text)}&request_id=${requestId}`,
  })
    .then((res) => res.json())
    .then((data) => {
      setTimeout(() => {
        const typing = document.getElementById(typingId);
        if (typing) typing.remove();

        messages.innerHTML += `
        <div class="ai-message">
          ${data.reply}
          <div class="time">${getTime()}</div>
        </div>
      `;

        messages.scrollTop = messages.scrollHeight;
      }, 1); // 1.5 saniyə gözləmə (pro effect)
    });
}

function stopAI() {
  window.location.href = "AI_login_users.php?page=sorgular";
}
