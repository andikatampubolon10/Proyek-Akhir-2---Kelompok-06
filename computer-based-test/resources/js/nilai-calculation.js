/**
 * Script untuk menangani perhitungan nilai
 */

document.addEventListener("DOMContentLoaded", () => {
  // Tombol hitung nilai
  const calculateAllBtn = document.getElementById("calculateAllBtn")

  if (calculateAllBtn) {
    calculateAllBtn.addEventListener("click", function () {
      const idKursus = this.getAttribute("data-id-kursus")

      // Konfirmasi sebelum menghitung
      if (confirm("Apakah Anda yakin ingin menghitung semua nilai?")) {
        // Tampilkan loading
        this.disabled = true
        this.innerHTML = '<i class="fas fa-spinner fa-spin mr-1"></i> Menghitung...'

        // Kirim request AJAX untuk menghitung nilai
        fetch(`/Guru/calculate-all-nilai/${idKursus}`, {
          method: "POST",
          headers: {
            "Content-Type": "application/json",
            "X-CSRF-TOKEN": document.querySelector('meta[name="csrf-token"]').getAttribute("content"),
          },
        })
          .then((response) => response.json())
          .then((data) => {
            // Kembalikan tampilan tombol
            calculateAllBtn.disabled = false
            calculateAllBtn.innerHTML = '<i class="fas fa-calculator mr-1"></i> Hitung Nilai'

            if (data.success) {
              // Tampilkan nilai untuk setiap siswa
              for (const siswaId in data.data.hasil) {
                const nilaiCell = document.getElementById(`nilai-${siswaId}`)
                if (nilaiCell) {
                  // Update nilai
                  nilaiCell.textContent = Number.parseFloat(data.data.hasil[siswaId].nilai_total).toFixed(2)

                  // Tambahkan efek highlight
                  nilaiCell.classList.add("highlight")

                  // Hapus class highlight setelah animasi selesai
                  setTimeout(() => {
                    nilaiCell.classList.remove("highlight")
                  }, 2000)
                }
              }

              // Tampilkan pesan sukses
              alert(`Perhitungan nilai berhasil dilakukan untuk ${data.data.jumlah_siswa} siswa!`)
            } else {
              alert("Terjadi kesalahan: " + data.message)
            }
          })
          .catch((error) => {
            // Kembalikan tampilan tombol
            calculateAllBtn.disabled = false
            calculateAllBtn.innerHTML = '<i class="fas fa-calculator mr-1"></i> Hitung Nilai'

            alert("Terjadi kesalahan: " + error.message)
          })
      }
    })
  }
})
