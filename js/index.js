const basketIcon = document.querySelector('.iconBtn[href="#"]'); // yalnız "#" olan icon
basketIcon.addEventListener("click", function (e) {
  e.preventDefault();
  document.getElementById("sidePanel").classList.add("activebasket");
});

document.getElementById("closePanel").addEventListener("click", function () {
  document.getElementById("sidePanel").classList.remove("activebasket");
});

const sidePanel = document.getElementById("sidePanel");
const basketItems = document.getElementById("basketItems");
const basketCount = document.getElementById("basketCount");
const emptyBasket = document.getElementById("emptyBasket");
const totalPriceElem = document.getElementById("totalPrice");
const checkoutBtn = document.getElementById("checkoutBtn");

document.addEventListener("click", function (e) {
  // Səbətə əlavə et
  if (e.target.classList.contains("add-to-cart")) {
    e.preventDefault();
    const btn = e.target;
    const id = btn.dataset.id;
    const name = btn.dataset.name;
    const price = parseFloat(btn.dataset.price);

    addToBasket(id, name, price);
  }

  // Məhsulu sil
  if (e.target.classList.contains("remove-item")) {
    const id = e.target.dataset.id;
    removeFromBasket(id);
  }

  // Say artır
  if (e.target.classList.contains("increase-item")) {
    const id = e.target.dataset.id;
    changeQty(id, 1);
  }

  // Say azaldır
  if (e.target.classList.contains("decrease-item")) {
    const id = e.target.dataset.id;
    changeQty(id, -1);
  }
});

// Səbəti PHP session-a əlavə edir
function addToBasket(id, name, price) {
  fetch("basket_ajax.php", {
    method: "POST",
    headers: {
      "Content-Type": "application/x-www-form-urlencoded",
    },
    body: `action=add&id=${id}&name=${encodeURIComponent(name)}&price=${price}`,
  }).then(() => renderBasket());
}

function removeFromBasket(id) {
  fetch("basket_ajax.php", {
    method: "POST",
    headers: {
      "Content-Type": "application/x-www-form-urlencoded",
    },
    body: `action=remove&id=${id}`,
  }).then(() => renderBasket());
}

function changeQty(id, qtyChange) {
  fetch("basket_ajax.php", {
    method: "POST",
    headers: {
      "Content-Type": "application/x-www-form-urlencoded",
    },
    body: `action=update&id=${id}&qtyChange=${qtyChange}`,
  }).then(() => renderBasket());
}

// Səbəti göstər
function renderBasket() {
  fetch("basket_ajax.php?action=view")
    .then((res) => res.json())
    .then((data) => {
      basketItems.innerHTML = "";
      let totalCount = 0;
      let totalPrice = 0;

      if (data.length === 0) {
        emptyBasket.style.display = "block";
      } else {
        emptyBasket.style.display = "none";
        data.forEach((item) => {
          totalCount += item.qty;
          totalPrice += item.qty * parseFloat(item.price);

          basketItems.innerHTML += `
                    <div class="basket-item">
                        <strong>${item.name}</strong>
                        <p>
                            <button class="decrease-item" data-id="${item.id}">-</button>
                            ${item.qty}
                            <button class="increase-item" data-id="${item.id}">+</button>
                            x ${item.price} AZN
                        </p>
                        <button class="remove-item" data-id="${item.id}">Sil</button>
                    </div>
                `;
        });
      }

      basketCount.innerText = totalCount;
      totalPriceElem.innerText = "Ümumi: " + totalPrice.toFixed(2) + " AZN";
      sidePanel.classList.add("activebasket");
    });
}
window.addEventListener("scroll", function () {
  const header = document.querySelector(".header");

  if (window.scrollY > 50) {
    header.classList.add("scrolled");
  } else {
    header.classList.remove("scrolled");
  }
});
