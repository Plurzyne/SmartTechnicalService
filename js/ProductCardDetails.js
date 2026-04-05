document.addEventListener("DOMContentLoaded", function () {
  const productAbout = document.querySelector(".productAbout");
  const comment = document.querySelector(".comment");
  const shareBtn = document.querySelector(".shareBtn");

  /* =============================== */
  /* XÜSUSİYYƏTLƏR */
  /* =============================== */

  const featureBox = document.createElement("div");
  featureBox.className = "dropdownBox";
  featureBox.innerHTML = `
    <ul>
        <li>Prosessor: Intel / AMD</li>
        <li>RAM: 16GB</li>
        <li>Yaddaş: SSD</li>
        <li>Videokart: Dedicated</li>
        <li>Zəmanət: 12 ay</li>
    </ul>
  `;
  productAbout.after(featureBox);

  productAbout.addEventListener("click", () => {
    featureBox.classList.toggle("open");
    productAbout.querySelector(".plus").textContent =
      featureBox.classList.contains("open") ? "-" : "+";
  });

  /* =============================== */
  /* RƏYLƏR + SYSTEM */
  /* =============================== */

  const commentBox = document.createElement("div");
  commentBox.className = "dropdownBox";
  commentBox.innerHTML = `
    <div class="reviewForm">
        <div class="starRating">
            <span data-star="1">★</span>
            <span data-star="2">★</span>
            <span data-star="3">★</span>
            <span data-star="4">★</span>
            <span data-star="5">★</span>
        </div>
        <textarea placeholder="Rəyinizi yazın..."></textarea>
        <button>Göndər</button>
    </div>
  `;
  comment.after(commentBox);

  comment.addEventListener("click", () => {
    commentBox.classList.toggle("open");
    comment.querySelector(".plus").textContent = commentBox.classList.contains(
      "open",
    )
      ? "-"
      : "+";
  });

  /* =============================== */
  /* ⭐ REVIEW LOGIC */
  /* =============================== */

  let selectedStar = 0;
  let reviews = [];

  const stars = commentBox.querySelectorAll(".starRating span");
  const textarea = commentBox.querySelector("textarea");
  const button = commentBox.querySelector("button");

  function highlightStars(count) {
    stars.forEach((star) => {
      star.classList.toggle("active", star.dataset.star <= count);
    });
  }

  stars.forEach((star) => {
    star.addEventListener("mouseover", () => {
      highlightStars(star.dataset.star);
    });

    star.addEventListener("mouseout", () => {
      highlightStars(selectedStar);
    });

    star.addEventListener("click", () => {
      selectedStar = parseInt(star.dataset.star);
      highlightStars(selectedStar);
    });
  });

  button.addEventListener("click", () => {
    const text = textarea.value;

    if (selectedStar === 0) {
      alert("Ulduz seç!");
      return;
    }

    if (text.trim() === "") {
      alert("Rəy yaz!");
      return;
    }

    reviews.push({
      star: selectedStar,
      text: text,
    });

    textarea.value = "";
    selectedStar = 0;
    highlightStars(0);

    updateRating();
  });

  function updateRating() {
    let total = 0;

    reviews.forEach((r) => {
      total += r.star;
    });

    let avg = reviews.length ? (total / reviews.length).toFixed(1) : 0;

    document.querySelector(".rating-value").innerText = avg;
    document.querySelector(".review-count").innerText = reviews.length + " rəy";
  }

  /* =============================== */
  /* SHARE */
  /* =============================== */

  shareBtn.addEventListener("click", () => {
    navigator.clipboard.writeText(window.location.href);

    let msg = document.querySelector(".shareMsg");
    if (!msg) {
      msg = document.createElement("div");
      msg.className = "shareMsg";
      msg.textContent = "Link kopyalandı ✅";
      shareBtn.after(msg);
    }

    msg.style.opacity = "1";
    setTimeout(() => {
      msg.style.opacity = "0";
    }, 2000);
  });
});
