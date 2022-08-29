window.addEventListener("DOMContentLoaded", (event) => {
  const datatablesSimple = document.getElementById("table");
  if (datatablesSimple) {
    new simpleDatatables.DataTable(datatablesSimple);
  }
});
