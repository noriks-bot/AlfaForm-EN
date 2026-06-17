function toggleMobileMenu() {
  const menu = document.getElementById('mobileMenu');
  menu.classList.toggle('active');
}

function openLanguageModal() {
  document.getElementById("languageModal").style.display = "flex";
}

function closeLanguageModal() {
  document.getElementById("languageModal").style.display = "none";
}

window.addEventListener("click", function(e) {
  const modal = document.getElementById("languageModal");
  if (e.target === modal) {
    closeLanguageModal();
  }
});
