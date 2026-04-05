document.querySelectorAll(".category-head").forEach((item) => {
  item.addEventListener("click", () => {
    const sub = item.nextElementSibling;
    const arrow = item.querySelector(".arrow");

    if (sub) {
      sub.style.display = sub.style.display === "block" ? "none" : "block";
      arrow.style.transform =
        sub.style.display === "block" ? "rotate(180deg)" : "rotate(0deg)";
    }
  });
});
