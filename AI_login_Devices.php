<link rel="stylesheet" href="./css/AI_login_Devices.css">
<link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.0/css/all.min.css" rel="stylesheet">

<div class="wrapper">

    <div class="addCard" onclick="openModal()">
        <i class="fa-solid fa-plus"></i>
        <span>Qurğu əlavə et</span>
    </div>

    <div id="deviceContainer" class="device-grid"></div>

</div>

<!-- MODAL -->
<div class="modal" id="deviceModal">
    <div class="modal-box">
        <span class="close-btn" onclick="closeModal()">&times;</span>
        <h3 id="modalTitle">Yeni Qurğu</h3>

        <input type="text" id="deviceName" placeholder="Qurğunun adı">

        <select id="deviceType">
            <option value="Printer"> Printer</option>
            <option value="Qulaqlıq"> Qulaqlıq</option>
            <option value="Klaviatura"> Klaviatura</option>
            <option value="Telefon"> Telefon</option>
        </select>

        <button onclick="submitDevice()">Qeyd et</button>
    </div>
</div>

<div class="modal" id="detailModal">
    <div class="modal-box">
        <span class="close-btn" onclick="closeDetail()">&times;</span>
        <h3 id="detailTitle"></h3>
        <p id="detailContent"></p>

        <div class="modal-actions">
            <button onclick="editFromDetail()">Redaktə et</button>
            <button onclick="deleteFromDetail()">Sil</button>
        </div>
    </div>
</div>

<script>
    const deviceContainer = document.getElementById("deviceContainer");
    const deviceModal = document.getElementById("deviceModal");
    const detailModal = document.getElementById("detailModal");

    let selectedCard = null;
    let editingId = null;

    /* =========================
       LOAD DEVICES
    ========================= */
    async function loadDevices() {
        if (!window.userId) {
            console.error("userId not ready yet");
            return;
        }
        try {
            const res = await fetch(`/api/devices/owner/${window.userId}`);
            if (!res.ok) throw new Error("Failed to load devices");
            const devices = await res.json();

            deviceContainer.innerHTML = "";

            const counts = {};

            devices.forEach(device => {
                const type = device.type;

                if (!counts[type]) counts[type] = 1;
                else counts[type]++;

                const number = counts[type];

                const card = document.createElement("div");
                card.className = "device-card";
                card.dataset.id = device.id;
                card.dataset.name = device.name;
                card.dataset.type = device.type;

                card.innerText = `${device.type} ${number}`;

                card.onclick = () => openDetail(card);

                deviceContainer.appendChild(card);
            });

        } catch (err) {
            console.error("Load devices error:", err);
        }
    }

    /* =========================
       ADD / EDIT DEVICE
    ========================= */
    async function submitDevice() {
        const name = document.getElementById("deviceName").value;
        const type = document.getElementById("deviceType").value;

        if (!name) return alert("Ad daxil edin");

        try {
            if (editingId) {
                // UPDATE
                await fetch(`/api/devices/${editingId}`, {
                    method: "PUT",
                    headers: { "Content-Type": "application/json" },
                    body: JSON.stringify({
                        deviceName: name,
                        deviceType: type
                    })
                });
            } else {
                // CREATE
                await fetch(`/api/devices`, {
                    method: "POST",
                    headers: { "Content-Type": "application/json" },
                    body: JSON.stringify({
                        ownerId: window.userId,
                        deviceName: name,
                        deviceType: type
                    })
                });
            }

            closeModal();
            editingId = null;
            loadDevices();

        } catch (err) {
            console.error("Submit error:", err);
        }
    }

    /* =========================
       DELETE
    ========================= */
    async function deleteFromDetail() {
        if (!confirm("Silmək istədiyinizə əminsiniz?")) return;

        try {
            await fetch(`/api/devices/${selectedCard.dataset.id}`, {
                method: "DELETE"
            });

            closeDetail();
            loadDevices();

        } catch (err) {
            console.error("Delete error:", err);
        }
    }

    /* =========================
       DETAIL MODAL
    ========================= */
    function openDetail(card) {
        selectedCard = card;

        document.getElementById("detailTitle").innerText = card.innerText;
        document.getElementById("detailContent").innerHTML =
            `<strong>Ad:</strong> ${card.dataset.name}<br>
         <strong>Tip:</strong> ${card.dataset.type}`;

        detailModal.classList.add("active");
    }

    function editFromDetail() {
        document.getElementById("deviceName").value = selectedCard.dataset.name;
        document.getElementById("deviceType").value = selectedCard.dataset.type;

        editingId = selectedCard.dataset.id;

        closeDetail();
        openModal();
    }

    /* =========================
       MODALS
    ========================= */
    function openModal() {
        deviceModal.classList.add("active");
    }

    function closeModal() {
        deviceModal.classList.remove("active");
        document.getElementById("deviceName").value = "";
    }

    function closeDetail() {
        detailModal.classList.remove("active");
    }

    /* =========================
       INIT
    ========================= */
    window.addEventListener("DOMContentLoaded", () => {
        loadDevices();
    });
</script>