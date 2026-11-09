
document.addEventListener("DOMContentLoaded", function () {
    const form = document.querySelector("form");

    if (!form) return;

    form.addEventListener("submit", function (event) {
        const nim = form.querySelector('[name="nim"]').value.trim();
        const nama = form.querySelector('[name="nama"]').value.trim();
        const prodi = form.querySelector('[name="program_studi"]').value.trim();
        const email = form.querySelector('[name="email"]').value.trim();

        if (!nim || !nama || !prodi || !email) {
            alert("Semua kolom wajib diisi!");
            event.preventDefault();
            return;
        }

        if (!/^[^\s@]+@[^\s@]+\.[^\s@]+$/.test(email)) {
            alert("Masukkan alamat email yang valid!");
            event.preventDefault();
            return;
        }

        if (!confirm("Apakah data sudah benar dan ingin disimpan?")) {
            event.preventDefault();
        }
    });
});
