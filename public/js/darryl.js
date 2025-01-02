const inputEmail = document.getElementById("inputEmail");
const inputSandi = document.getElementById("inputPassword");
const konfirmasiSandi = document.getElementById("konfirmasiSandi");

const togglesandi = document.getElementById("togglePassword");

function toggler() {
  if (togglesandi.checked) {
    inputSandi.type = "text";
    konfirmasiSandi.type = "text";
  } else {
    inputSandi.type = "password";
    konfirmasiSandi.type = "password";
  }
}

togglesandi.addEventListener("change", toggler);

function cekEmail(email) {
  const constraints = /^[a-zA-Z0-9._%+-]+@gmail\.com$/;
  if (!constraints.test(email)) {
    alert("Email tidak valid. Pastikan menggunakan alamat email yang benar.");
    return false;
  }
  return true;
}

function cekSama(password1, password2) {
  if (password1 !== password2) {
    alert("Kata sandi tidak sesuai. Pastikan kedua kata sandi sama.");
    return false;
  }
  return true;
}

function cekPasswordStrength(pass) {
  const hasNumber = /\d/.test(pass); // Check for at least one digit
  const hasSpecialChar = /[!@#$%^&*(),.?":{}|<>]/.test(pass); // Check for at least one special character
  const hasUpperCase = /[A-Z]/.test(pass); // Check for at least one uppercase letter
  const hasLowerCase = /[a-z]/.test(pass); // Check for at least one lowercase letter
  const hasMinLength = pass.length >= 8; // Check for minimum length of 8 characters

  if (
    hasNumber &&
    hasSpecialChar &&
    hasUpperCase &&
    hasLowerCase &&
    hasMinLength
  ) {
    return true;
  }

  const missingCriteria = [];
  if (!hasNumber) missingCriteria.push("angka");
  if (!hasSpecialChar) missingCriteria.push("special chars");
  if (!hasUpperCase) missingCriteria.push("huruf kapital");
  if (!hasLowerCase) missingCriteria.push("huruf kecil");
  if (!hasMinLength) missingCriteria.push("panjang minimal 8 karakter");

  alert(
    `Kata sandi tidak memiliki: ${missingCriteria.join(", ")}`
  );
  return false;
}

function validate(event) {
  const currentPage = window.location.pathname;

  switch (currentPage) {
    case "/": // darryl_landing
      if (!inputEmail.value || !inputPassword.value) {
        alert("Formulir tidak lengkap.");
        event.preventDefault();
        return false;
      }

      if (!cekEmail(inputEmail.value)) {
        event.preventDefault();
        return false;
      }

      if (!cekPasswordStrength(inputPassword.value)) {
        event.preventDefault();
        return false;
      }

      if (!cekSama(inputSandi.value, konfirmasiSandi.value)) {
        event.preventDefault();
        return false;
      }

      if (
        cekEmail(inputEmail.value) &&
        cekPasswordStrength(inputSandi.value) &&
        cekSama(inputSandi.value, konfirmasiSandi.value)
      ) {
        window.location.href = "/masuk";
      }
      break;

    case "/masuk": // darryl_masuk
      if (!inputEmail.value || !inputSandi.value) {
        alert("Formulir tidak lengkap.");
        event.preventDefault();
        return false;
      }
      if (cekEmail(inputEmail.value)) {
        window.location.href = "/dashboard"
      } 
      break;
  }
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