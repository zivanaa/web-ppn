document.addEventListener("DOMContentLoaded", () => {
  const items = document.querySelectorAll(".faq-item");

  items.forEach(item => {
    const question = item.querySelector(".faq-question");
    const icon = question.querySelector(".icon");

    question.addEventListener("click", () => {
      // Tutup yang lain
      items.forEach(i => {
        if (i !== item) {
          i.classList.remove("active");
          const ic = i.querySelector(".icon");
          ic.classList.remove("bi-chevron-up");
          ic.classList.add("bi-chevron-down");
        }
      });

      // Toggle aktif
      item.classList.toggle("active");

      if (item.classList.contains("active")) {
        icon.classList.remove("bi-chevron-down");
        icon.classList.add("bi-chevron-up");
      } else {
        icon.classList.remove("bi-chevron-up");
        icon.classList.add("bi-chevron-down");
      }
    });
  });
});
