let deviceCounts = {};
let editingCard = null;
let selectedCard = null;

function openModal(edit = false) {
  document.getElementById("deviceModal").classList.add("active");
  if (!edit) editingCard = null;
}

function closeModal() {
  document.getElementById("deviceModal").classList.remove("active");
  document.getElementById("deviceName").value = "";
}

function saveDevice() {
  const name = document.getElementById("deviceName").value;
  const type = document.getElementById("deviceType").value;

  if (!name) return alert("Ad daxil edin");

  if (editingCard) {
    editingCard.dataset.name = name;
    editingCard.dataset.type = type;
    editingCard.innerHTML = type;
    closeModal();
    return;
  }

  if (!deviceCounts[type]) deviceCounts[type] = 1;
  else deviceCounts[type]++;

  const number = deviceCounts[type];

  const card = document.createElement("div");
  card.className = "device-card";
  card.innerHTML = `${type} ${number}`;
  card.dataset.name = name;
  card.dataset.type = type;

  card.onclick = function () {
    openDetail(card);
  };

  document.getElementById("deviceContainer").appendChild(card);
  closeModal();
}

function openDetail(card) {
  selectedCard = card;
  document.getElementById("detailTitle").innerText = card.innerText;
  document.getElementById("detailContent").innerHTML =
    `<strong>Ad:</strong> ${card.dataset.name}<br>
     <strong>Tip:</strong> ${card.dataset.type}`;

  document.getElementById("detailModal").classList.add("active");
}

function editFromDetail() {
  document.getElementById("deviceName").value = selectedCard.dataset.name;
  document.getElementById("deviceType").value = selectedCard.dataset.type;

  editingCard = selectedCard;
  document.getElementById("detailModal").classList.remove("active");
  openModal(true);
}

function deleteFromDetail() {
  selectedCard.remove();
  document.getElementById("detailModal").classList.remove("active");
}
window.onclick = function (e) {
  const deviceModal = document.getElementById("deviceModal");
  const detailModal = document.getElementById("detailModal");

  if (e.target === deviceModal) {
    closeModal();
  }

  if (e.target === detailModal) {
    closeDetail();
  }
};
document.addEventListener("keydown", function (e) {
  if (e.key === "Escape") {
    closeModal();
    closeDetail();
  }
});
function closeDetail() {
  document.getElementById("detailModal").classList.remove("active");
}
