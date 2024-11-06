document.getElementById("amount").addEventListener("input", function (e) {
  let value = e.target.value.replace(/\./g, "").replace(/,/g, ".");
  if (!isNaN(value)) {
    e.target.value = formatNumber(value);
  }
});

function formatNumber(num) {
  return num
    .toString()
    .replace(/\B(?=(\d{3})+(?!\d))/g, ".")
    .replace(".", ",");
}
