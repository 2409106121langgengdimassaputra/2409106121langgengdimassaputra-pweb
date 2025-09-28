
const paketButtons = document.querySelectorAll(".btn-pilih");
const paketSelect = document.getElementById("paket");
const form = document.querySelector("form");
const darkModeToggle = document.getElementById("dark-toggle");

paketButtons.forEach(button => {
  button.addEventListener("click", () => {
    const value = button.getAttribute("data-value");
    paketSelect.value = value;
    alert(`Paket ${value} UC dipilih!`);
  });
});

form.addEventListener("submit", (e) => {
  e.preventDefault();

  const userId = document.getElementById("user-id").value.trim();
  const paket = paketSelect.value;
  const metode = document.getElementById("metode").value;

  if (!userId || !paket || !metode) {
    alert("Mohon lengkapi semua field sebelum submit.");
    return;
  }

  alert(`Top Up berhasil!
User ID: ${userId}
Paket: ${paket} UC
Metode: ${metode}`);
  form.reset();
});

if (darkModeToggle) {
  darkModeToggle.addEventListener("click", () => {
    document.body.classList.toggle("dark-mode");
  });
}

async function fetchRate() {
  try {
    const res = await fetch("https://open.er-api.com/v6/latest/USD");
    const data = await res.json();
    const rate = data.rates.IDR;
    document.getElementById("kurs").innerText =
      `Kurs saat ini (USD → IDR): Rp ${rate.toLocaleString()}`;
  } catch (err) {
    console.error("Gagal ambil kurs:", err);
  }
}

fetchRate();
