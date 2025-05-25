const inputEmail = document.getElementById("inputEmail");
const inputSandi = document.getElementById("inputPassword");
const konfirmasiSandi = document.getElementById("konfirmasiSandi");

const togglesandi = document.getElementById("togglePassword");

document
    .getElementById("togglePassword")
    .addEventListener("change", function () {
        const passwordInput = document.getElementById("inputPassword");
        passwordInput.type = this.checked ? "text" : "password";
    });
document.querySelector("form").addEventListener("submit", () => {
    console.log("Form submitted");
});

function cekEmail(email) {
    const constraints = /^[a-zA-Z0-9._%+-]+@gmail\.com$/;
    if (!constraints.test(email)) {
        alert(
            "Email tidak valid. Pastikan menggunakan alamat email yang benar."
        );
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
    const hasNumber = /\d/.test(pass);
    const hasSpecialChar = /[!@#$%^&*(),.?":{}|<>]/.test(pass);
    const hasUpperCase = /[A-Z]/.test(pass);
    const hasLowerCase = /[a-z]/.test(pass);
    const hasMinLength = pass.length >= 8;

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

    alert(`Kata sandi tidak memiliki: ${missingCriteria.join(", ")}`);
    return false;
}

function validate(event) {
    const namaLengkap = document.getElementById("namaLengkap").value;
    const nomorTelepon = document.getElementById("nomorTelepon").value;
    const username = document.getElementById("username").value;
    const inputEmail = document.getElementById("inputEmail").value;
    const inputPassword = document.getElementById("inputPassword").value;
    const konfirmasiSandi = document.getElementById("konfirmasiSandi").value;
    const nikKtp = document.getElementById("nikKtp").value;

    const requiredFields = [
        { value: namaLengkap, name: "Nama lengkap" },
        { value: nomorTelepon, name: "Nomor telepon" },
        { value: username, name: "Username" },
        { value: inputEmail, name: "Email" },
        { value: inputPassword, name: "Kata sandi" },
        { value: konfirmasiSandi, name: "Konfirmasi sandi" },
        { value: nikKtp, name: "NIK KTP" },
    ];

    // perulangan untuk check apakah semua fields sudah terisi
    for (const field of requiredFields) {
        if (!field.value) {
            alert(`${field.name} wajib diisi.`);
            event.preventDefault();
            return false;
        }
    }

    if (namaLengkap.length < 3) {
        alert("Nama lengkap minimal 3 karakter.");
        event.preventDefault();
        return false;
    }
    if (username.length < 3) {
        alert("Username minimal 3 karakter.");
        event.preventDefault();
        return false;
    }

    if (!/^[0-9]+$/.test(nomorTelepon)) {
        alert("Nomor telepon hanya boleh berisi angka.");
        event.preventDefault();
        return false;
    }

    if (!/^\d{10}$/.test(nikKtp)) {
        alert("NIK KTP harus 10 digit angka.");
        event.preventDefault();
        return false;
    }

    if (!cekEmail(inputEmail)) {
        event.preventDefault();
        return false;
    }

    if (!cekPasswordStrength(inputPassword)) {
        event.preventDefault();
        return false;
    }

    if (!cekSama(inputPassword, konfirmasiSandi)) {
        event.preventDefault();
        return false;
    }

    return true;
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
