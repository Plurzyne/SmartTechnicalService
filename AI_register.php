<link rel="stylesheet" href="./css//Aİ_register.css">
<div class="input">
    <div class="login-box" id="registerForm">

        <a href="index.php" class="forgot">← Geriya</a>

        <h1>Qeydiyyat</h1>
        <p class="subtitle">Yeni hesab yaradın</p>

        <!-- FORM START -->
        <form id="registerForm">

            <label>Ad</label>
            <input type="text" id="name" name="name" placeholder="Adınız">

            <label>Soyad</label>
            <input type="text" id="surname" name="surname" placeholder="Soyadınız">

            <label>Email</label>
            <input type="email" id="email" name="email" placeholder="email@example.com">

            <label>Tel</label>
            <input type="text" id="tel" name="tel" placeholder="+994">

            <label>Parol</label>
            <input type="password" id="parol" name="parol" placeholder="••••••••">

            <label class="custom-checkbox">
                <input type="checkbox" id="ustaCheck" name="usta">
                <span class="checkmark"></span>
                <span class="checkbox-text">Mən ustayam</span>
            </label>

            <div id="ustaTypeBox" style="display:none;">
                <label>Usta növü</label>
                <select name="usta_novu">
                    <option value="">Seçin</option>
                    <option value="printer">Printer ustası</option>
                    <option value="komputer">Kompüter ustası</option>
                    <option value="telefon">Telefon ustası</option>
                </select>
            </div>

            <button class="btn-primary" type="submit">Qeydiyyatdan keç</button>
        </form>
        <!-- FORM END -->

    </div>
</div>
<script>
    const form = document.getElementById("registerForm");
    const ustaCheck = document.getElementById("ustaCheck");
    const ustaBox = document.getElementById("ustaTypeBox");

    ustaCheck.addEventListener("change", () => {
        ustaBox.style.display = ustaCheck.checked ? "block" : "none";
    });

    form.addEventListener("submit", async function (e) {
        e.preventDefault();

        const user = {
            firstName: document.getElementById("name").value,
            lastName: document.getElementById("surname").value,
            email: document.getElementById("email").value,
            phone: document.getElementById("tel").value,
            password: document.getElementById("parol").value,
            isTechnician: ustaCheck.checked
        };

        try {
            const response = await fetch("/api/users/register", {
                method: "POST",
                headers: {
                    "Content-Type": "application/json"
                },
                body: JSON.stringify(user)
            });

            const data = await response.text(); // 🔥 FIX

            if (response.ok) {
                alert("Qeydiyyat uğurlu oldu!");
                window.location.href = "index.php";
            } else {
                alert(data || "Xəta baş verdi!");
            }

        } catch (error) {
            console.error(error);
            alert("Serverə qoşulmaq mümkün olmadı!");
        }
    });
</script>