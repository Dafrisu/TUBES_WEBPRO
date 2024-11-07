// Background control
var particles = Particles.init({
  selector: ".background",
  color: "#658864",
  maxParticles: 120,
  // buat particlesnya nyambung !optional
  connectParticles: true,
  // set minimal jarak antar partikel !optional
  minDistance: 130,
});

const sandi = document.getElementById("inputPassword");
const togglesandi = document.getElementById("togglePassword");

function toggler() {
  if (togglesandi.checked) {
    sandi.type = "text";
  } else {
    sandi.type = "password";
  }
}

togglesandi.addEventListener("change", toggler);

const nums = [
  "0","1","2","3","4","5","6","7","8","9"
];


function Login() {
  const email = document.getElementById("inputEmail");
  const sandi = document.getElementById("inputPassword");
  const konfirmasiEmail = document.getElementById("konfirmasiSandi");
  var login = false;

  if (sandi.value != konfirmasiEmail.value) {
    alert("Sandi tidak sama");
  }

  if (!email.value.includes("@gmail.com")) {
    alert("Email tidak valid");
  }

  // if (!sandi.value.includes(nums)) {
  //   alert("Sandi harus mengandung nomor");
  // } else {
  //   login = true;
  // }

  if (login) {
    window.location.href = "darryl_masuk.html";
  }
}

// password tidak sama
// minimal ada Char, angka, huruf besar, huruf kecil, special char (#$%)
// email kalo tidak contains @gmail salahin
