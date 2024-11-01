// Background control
var particles = Particles.init({
	selector: '.background',
  color: '#658864',
  maxParticles: 120,
  // buat particlesnya nyambung !optional
  connectParticles: true,
  // set minimal jarak antar partikel !optional
  minDistance: 130
});

const sandi = document.getElementById("inputPassword");
const togglesandi = document.getElementById("togglePassword");

function toggler() {
  if(togglesandi.checked) {
    sandi.type = "text"
  } else {
    sandi.type = "password"
  }
}

togglesandi.addEventListener("change", toggler);

