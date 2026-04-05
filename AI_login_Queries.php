<?php
$user_id = $_GET['id'] ?? null;

if (!$user_id) {
    header("Location: index.php");
    exit();
}


?>

<link rel="stylesheet" href="./css/AI_login_Devices.css">

<div class="wrapper">

    <div class="addCard" onclick="openModal()">
        + Sorğu əlavə et
    </div>

    <div id="requestContainer"></div>

</div>

<!-- ================= DEVICE MODAL ================= -->
<div class="modal" id="deviceModal">
    <div class="modal-box">
        <span onclick="closeModal()" style="float:right;cursor:pointer;">×</span>

        <h3>Qurğunu seç</h3>

        <select id="deviceType"></select>

        <br><br>

        Problemi yaz:
        <textarea id="deviceName"></textarea>

        <br><br>

        <button onclick="saveDevice()">Davam et</button>
    </div>
</div>

<!-- ================= DETAIL MODAL ================= -->
<div class="modal" id="detailModal">
    <div class="modal-box">
        <span onclick="closeDetail()" style="float:right;cursor:pointer;">×</span>

        <h3 id="detailTitle">Sorğunu təsdiqlə</h3>
        <p id="detailContent"></p>

        <form method="POST">
            <input type="hidden" name="device_id" id="hiddenDeviceId">
            <input type="hidden" name="problem" id="hiddenProblem">

            <button type="submit">Sorğunu yarat</button>
        </form>
    </div>
</div>

<script>
    const deviceModal = document.getElementById("deviceModal");
    const detailModal = document.getElementById("detailModal");

    const requestContainer = document.getElementById("requestContainer");
    const deviceSelect = document.getElementById("deviceType");

    let devicesData = {};

    /* =========================
       LOAD DEVICES
    ========================= */
    async function loadDevices() {
        try {
            const res = await fetch(`/api/devices/owner/${window.userId}`);
            if (!res.ok) throw new Error("Failed devices");

            const devices = await res.json();

            deviceSelect.innerHTML = "";

            devices.forEach(device => {
                devicesData[device.id] = device;

                const option = document.createElement("option");
                option.value = device.id;
                option.textContent = device.type + " " + device.id;

                deviceSelect.appendChild(option);
            });

        } catch (err) {
            console.error(err);
        }
    }

    /* =========================
       LOAD REQUESTS
    ========================= */
    async function loadRequests() {
        try {
            const res = await fetch(`/api/service-requests/user/${window.userId}`);
            if (!res.ok) throw new Error("Failed requests");

            const requests = await res.json();

            requestContainer.innerHTML = "";

            requests.forEach((req, index) => {
                const div = document.createElement("div");
                div.className = "addCard";
                div.innerText = "Sorğu " + (index + 1);

                div.onclick = () => openChat(req.id);

                requestContainer.appendChild(div);
            });

        } catch (err) {
            console.error(err);
        }
    }

    /* =========================
       CREATE REQUEST
    ========================= */
    async function createRequest(deviceId, problem) {
        try {
            const res = await fetch(`/api/service-requests`, {
                method: "POST",
                headers: { "Content-Type": "application/json" },
                body: JSON.stringify({
                    deviceId: deviceId,
                    problemDescription: problem
                })
            });

            if (!res.ok) throw new Error("Create failed");

            const data = await res.json();

            window.location.href = "OnlineChat.php?request_id=" + data.id;

        } catch (err) {
            console.error(err);
        }
    }

    /* =========================
       MODAL FLOW
    ========================= */
    function openModal() {
        deviceModal.classList.add("active");
    }

    function closeModal() {
        deviceModal.classList.remove("active");
    }

    function closeDetail() {
        detailModal.classList.remove("active");
    }

    function saveDevice() {
        const problem = document.getElementById("problemInput").value.trim();
        const deviceId = document.getElementById("deviceType").value;

        if (!problem) return alert("Problemi daxil edin!");

        const device = devicesData[deviceId];

        document.getElementById("detailContent").innerHTML =
            "<b>Qurğu:</b> " + device.name + "<br>" +
            "<b>Tip:</b> " + device.type + "<br>" +
            "<b>Problem:</b> " + problem;

        document.getElementById("hiddenDeviceId").value = deviceId;
        document.getElementById("hiddenProblem").value = problem;

        detailModal.classList.add("active");
        closeModal();
    }

    /* =========================
       FINAL SUBMIT
    ========================= */
    document.getElementById("requestForm").addEventListener("submit", function (e) {
        e.preventDefault();

        const deviceId = document.getElementById("hiddenDeviceId").value;
        const problem = document.getElementById("hiddenProblem").value;

        createRequest(deviceId, problem);
    });

    /* =========================
       CHAT
    ========================= */
    function openChat(id) {
        window.location.href = "OnlineChat.php?request_id=" + id;
    }

    /* =========================
       INIT
    ========================= */
    window.addEventListener("DOMContentLoaded", () => {
        loadDevices();
        loadRequests();
    });
</script>