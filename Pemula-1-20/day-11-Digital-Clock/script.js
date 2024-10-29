const timeElement = document.getElementById('time');
const dateElement = document.getElementById('date');
const greetingElement = document.getElementById('greeting');
const toggleModeButton = document.getElementById('toggleMode');

// Fungsi untuk mendapatkan waktu saat ini dan memperbarui tampilan
function updateClock() {
  const now = new Date();
  const hours = String(now.getHours()).padStart(2, '0');
  const minutes = String(now.getMinutes()).padStart(2, '0');
  const seconds = String(now.getSeconds()).padStart(2, '0');

  timeElement.textContent = `${hours}:${minutes}:${seconds}`;

  // Tampilkan tanggal dengan format Hari, Tanggal Bulan Tahun
  const options = { weekday: 'long', year: 'numeric', month: 'long', day: 'numeric' };
  dateElement.textContent = now.toLocaleDateString('en-EN', options);

  updateGreeting(hours);  // Panggil fungsi untuk mengupdate greeting
}

// Fungsi untuk menampilkan greeting berdasarkan jam
function updateGreeting(hours) {
  let greeting = 'Welcome!';
  if (hours >= 5 && hours < 10) {
    greeting = 'Good Morning!';
  } else if (hours >= 10 && hours < 18) {
    greeting = 'Good Afternoon!';
  } else if (hours >= 18 && hours < 22) {
    greeting = 'Good Evening!';
  } else {
    greeting = 'Good Night!';
  }
  greetingElement.textContent = greeting;
}

// Event Listener untuk tombol mode gelap/terang
toggleModeButton.addEventListener('click', () => {
  document.body.classList.toggle('dark-mode');
  const isDarkMode = document.body.classList.contains('dark-mode');
  toggleModeButton.innerHTML = isDarkMode ? '<i class="fas fa-sun me-2"></i>Switch to Light Mode' : '<i class="fas fa-moon me-2"></i>Switch to Dark Mode';
});

// Panggil updateClock setiap detik
setInterval(updateClock, 1000);

// Panggil fungsi pertama kali saat halaman dimuat
updateClock();
