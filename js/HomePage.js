function showRegister() {
  document.getElementById("loginForm").style.display = "none";
  document.getElementById("registerForm").style.display = "block";
}

function showLogin() {
  document.getElementById("registerForm").style.display = "none";
  document.getElementById("loginForm").style.display = "block";
}
document.addEventListener("DOMContentLoaded", function () {
  const checkbox = document.getElementById("ustaCheck");
  const ustaBox = document.getElementById("ustaTypeBox");

  checkbox.addEventListener("change", function () {
    if (this.checked) {
      ustaBox.style.display = "block";
    } else {
      ustaBox.style.display = "none";
    }
  });
});
