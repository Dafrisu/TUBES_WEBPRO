const togglesandi = document.getElementById("togglePassword");
const email = document.getElementById("inputEmail");
const sandi = document.getElementById("inputPassword");
const konfirmasiSandi = document.getElementById("konfirmasiSandi");

function toggler() {
  if (togglesandi.checked) {
    sandi.type = "text";
    konfirmasiSandi.type = "text";
  } else {
    sandi.type = "password";
    konfirmasiSandi.type = "password";
  }
}

togglesandi.addEventListener("change", toggler);

// const nums = [
//   "0","1","2","3","4","5","6","7","8","9"
// ];

function cekLanding() {
  var confirmSandi = false;
  var confirmEmail = false;

  if (sandi.value != konfirmasiSandi.value) {
    alert("Sandi tidak sama");
  } else {
    confirmSandi = true;
  }

  if (!email.value.includes("@gmail.com")) {
    alert("Email tidak valid");
  } else {
    confirmEmail = true;
  }

  if (confirmEmail && confirmSandi) {
    window.location.href = "darryl_masuk.html"
  }

  // if (!sandi.value.includes(nums)) {
  //   alert("Sandi harus mengandung nomor");
  // } else {
  //   login = true;
  // }
}

function cekMasuk() {
  var confirmEmail = false;

  if (!email.value.includes("@gmail.com")) {
    alert("Email tidak valid. harus menggunakan format email yang benar!");
  } else {
    confirmEmail = true;
  }

  if (confirmEmail) {
    window.location.href = "Dafa_Dashboard.html"
  }
}

function cek(pass) {
  const hasNumber = /\d/.test(pass); // Check for at least one digit
  const hasSpecialChar = /[!@#$%^&*(),.?":{}|<>]/.test(pass); // Check for at least one special character
  const hasUpperCase = /[A-Z]/.test(pass); // Check for at least one uppercase letter
  const hasLowerCase = /[a-z]/.test(pass); // Check for at least one lowercase letter
  const hasMinLength = pass.length >= 8; // Check for minimum length of 8 characters

  // Return validation result as an object
  return {
    hasNumber,
    hasSpecialChar,
    hasUpperCase,
    hasLowerCase,
    hasMinLength,
    isValid: hasNumber && hasSpecialChar && hasUpperCase && hasLowerCase && hasMinLength,
  };
}

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
