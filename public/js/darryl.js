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
  if (!email.includes("@gmail.com")) {
    alert("Invalid Email");
    return false;
  }
  return true;
}

function cekSama(p1, p2) {
  if (p1 !== p2) {
    alert("Sandi tidak sesuai");
    return false;
  }
  return true;
}

function validate() {
  const currentPage = window.location.pathname;

  switch (currentPage) {
    case "/darryl_landing.html":
      if (cekEmail(inputEmail.value) && cekSama(konfirmasiSandi.value, inputSandi.value)) {
        window.location.href = "darryl_masuk.html";
      }
      break;
    case "/darryl_masuk.html":
      if (cekEmail(inputEmail.value)) {
        window.location.href = "Dafa_Dashboard.html"
      } 
  }
}

// function cek(pass) {
//   const hasNumber = /\d/.test(pass); // Check for at least one digit
//   const hasSpecialChar = /[!@#$%^&*(),.?":{}|<>]/.test(pass); // Check for at least one special character
//   const hasUpperCase = /[A-Z]/.test(pass); // Check for at least one uppercase letter
//   const hasLowerCase = /[a-z]/.test(pass); // Check for at least one lowercase letter
//   const hasMinLength = pass.length >= 8; // Check for minimum length of 8 characters

//   // Return validation result as an object
//   return {
//     hasNumber,
//     hasSpecialChar,
//     hasUpperCase,
//     hasLowerCase,
//     hasMinLength,
//     isValid:
//       hasNumber &&
//       hasSpecialChar &&
//       hasUpperCase &&
//       hasLowerCase &&
//       hasMinLength,
//   };
// }

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
