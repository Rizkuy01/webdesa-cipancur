// Konfigurasi API Gemini (Ganti dengan API key Anda)
const GEMINI_API_KEY = "AIzaSyDohdZvUugYkQQcXX88PErAFX3OQ0QQXPg";
const GEMINI_API_URL =
  "https://generativelanguage.googleapis.com/v1beta/models/gemini-pro:generateContent";

// Database persuratan lokal untuk AI
const suratDatabase = {
  ktp: {
    nama: "KTP (Kartu Tanda Penduduk)",
    syarat: [
      "Fotokopi KK",
      "Surat pengantar RT/RW",
      "Pas foto 3x4 (2 lembar)",
      "Fotokopi akta kelahiran",
    ],
    prosedur:
      "Datang ke kantor desa dengan membawa persyaratan lengkap, isi formulir, tunggu proses verifikasi, ambil surat pengantar untuk ke Disdukcapil",
    waktu: "1-3 hari kerja",
    biaya: "Gratis",
  },
  kk: {
    nama: "KK (Kartu Keluarga)",
    syarat: [
      "Surat pengantar RT/RW",
      "Fotokopi KTP kepala keluarga",
      "Fotokopi akta nikah/cerai",
      "Fotokopi akta kelahiran seluruh anggota keluarga",
    ],
    prosedur:
      "Siapkan berkas, datang ke kantor desa, isi formulir permohonan, verifikasi data, terima surat pengantar ke Disdukcapil",
    waktu: "2-5 hari kerja",
    biaya: "Gratis",
  },
  domisili: {
    nama: "Surat Keterangan Domisili",
    syarat: [
      "Fotokopi KTP",
      "Fotokopi KK",
      "Surat pengantar RT/RW",
      "Pas foto 3x4 (1 lembar)",
    ],
    prosedur:
      "Datang ke kantor desa, isi formulir, serahkan persyaratan, tunggu verifikasi, ambil surat",
    waktu: "1-2 hari kerja",
    biaya: "Rp 5.000",
  },
  kelahiran: {
    nama: "Surat Keterangan Kelahiran",
    syarat: [
      "Surat keterangan lahir dari bidan/dokter",
      "Fotokopi KTP orang tua",
      "Fotokopi KK",
      "Fotokopi akta nikah orang tua",
    ],
    prosedur:
      "Lapor kelahiran maksimal 60 hari, bawa persyaratan ke kantor desa, isi formulir, verifikasi, terima surat pengantar ke Disdukcapil",
    waktu: "1-2 hari kerja",
    biaya: "Gratis",
  },
  kematian: {
    nama: "Surat Keterangan Kematian",
    syarat: [
      "Surat keterangan kematian dari dokter/rumah sakit",
      "Fotokopi KTP almarhum",
      "Fotokopi KK",
      "Surat pengantar RT/RW",
    ],
    prosedur:
      "Lapor kematian maksimal 30 hari, bawa persyaratan, isi formulir, verifikasi, terima surat keterangan",
    waktu: "1 hari kerja",
    biaya: "Gratis",
  },
  usaha: {
    nama: "Surat Izin Usaha",
    syarat: [
      "Fotokopi KTP",
      "Fotokopi KK",
      "Pas foto 3x4 (2 lembar)",
      "Denah lokasi usaha",
      "Surat pernyataan tidak mengganggu lingkungan",
    ],
    prosedur:
      "Isi formulir permohonan, serahkan berkas, survei lokasi, verifikasi, terima surat izin",
    waktu: "3-7 hari kerja",
    biaya: "Rp 25.000",
  },
};

// Fungsi untuk mencari informasi surat
function cariInfoSurat(query) {
  const kata = query.toLowerCase();
  for (let key in suratDatabase) {
    if (
      kata.includes(key) ||
      kata.includes(suratDatabase[key].nama.toLowerCase())
    ) {
      return suratDatabase[key];
    }
  }
  return null;
}

// Fungsi untuk mengirim pesan ke AI
async function sendMessage() {
  const userInput = document.getElementById("userInput");
  const chatMessages = document.getElementById("chatMessages");
  const loading = document.getElementById("loading");

  if (!userInput.value.trim()) return;

  // Tampilkan pesan user
  const userMessage = document.createElement("div");
  userMessage.className = "message user-message";
  userMessage.innerHTML = `<strong>Anda:</strong> ${userInput.value}`;
  chatMessages.appendChild(userMessage);

  const query = userInput.value;
  userInput.value = "";

  // Tampilkan loading
  loading.style.display = "block";
  chatMessages.scrollTop = chatMessages.scrollHeight;

  try {
    // Cek database lokal terlebih dahulu
    const infoSurat = cariInfoSurat(query);
    let response;

    if (infoSurat) {
      // Jika ditemukan di database lokal
      response =
        `📋 **${infoSurat.nama}**\n\n` +
        `**Persyaratan:**\n${infoSurat.syarat
          .map((s) => `• ${s}`)
          .join("\n")}\n\n` +
        `**Prosedur:** ${infoSurat.prosedur}\n\n` +
        `**Waktu Pengurusan:** ${infoSurat.waktu}\n\n` +
        `**Biaya:** ${infoSurat.biaya}\n\n` +
        `📞 Untuk informasi lebih lanjut, silakan hubungi kantor desa atau klik tombol WhatsApp di pojok kanan bawah.`;
    } else {
      // Jika tidak ditemukan, gunakan respons AI umum
      response = await getGeminiResponse(query);
    }

    // Tampilkan respons AI
    const aiMessage = document.createElement("div");
    aiMessage.className = "message ai-message";
    aiMessage.innerHTML = `<strong>🤖 AI Assistant:</strong> ${response.replace(
      /\n/g,
      "<br>"
    )}`;
    chatMessages.appendChild(aiMessage);
  } catch (error) {
    console.error("Error:", error);
    const errorMessage = document.createElement("div");
    errorMessage.className = "message ai-message";
    errorMessage.innerHTML = `<strong>🤖 AI Assistant:</strong> Maaf, terjadi kesalahan. Silakan coba lagi atau hubungi kantor desa melalui WhatsApp untuk bantuan langsung.`;
    chatMessages.appendChild(errorMessage);
  }

  // Sembunyikan loading
  loading.style.display = "none";
  chatMessages.scrollTop = chatMessages.scrollHeight;
}

// Fungsi untuk mendapatkan respons dari Gemini AI
async function getGeminiResponse(query) {
  const prompt = `Anda adalah asisten AI untuk pelayanan desa. Jawab pertanyaan berikut tentang persuratan dan birokrasi desa dengan ramah dan informatif. Jika tidak yakin, sarankan untuk menghubungi kantor desa langsung.

Pertanyaan: ${query}

Berikan jawaban yang spesifik tentang persyaratan, prosedur, dan informasi penting lainnya.`;

  const response = await fetch(`${GEMINI_API_URL}?key=${GEMINI_API_KEY}`, {
    method: "POST",
    headers: {
      "Content-Type": "application/json",
    },
    body: JSON.stringify({
      contents: [
        {
          parts: [
            {
              text: prompt,
            },
          ],
        },
      ],
    }),
  });

  if (!response.ok) {
    throw new Error("Gagal menghubungi AI service");
  }

  const data = await response.json();
  return data.candidates[0].content.parts[0].text;
}

// Fungsi untuk membuka WhatsApp
function openWhatsApp() {
  const phoneNumber = "6283140569054"; // Ganti dengan nomor WhatsApp desa
  const message = `Halo, saya ingin bertanya tentang persuratan desa. Bisa dibantu?`;
  const whatsappURL = `https://wa.me/${phoneNumber}?text=${encodeURIComponent(
    message
  )}`;
  window.open(whatsappURL, "_blank");
}

// Smooth scrolling untuk navigasi
document.querySelectorAll("nav a").forEach((anchor) => {
  anchor.addEventListener("click", function (e) {
    // Hanya jalankan smooth scroll jika href adalah link internal (#)
    if (this.getAttribute("href").startsWith("#")) {
      e.preventDefault();
      const target = document.querySelector(this.getAttribute("href"));
      if (target) {
        target.scrollIntoView({
          behavior: "smooth",
          block: "start",
        });
      }
    }
  });
});

// Auto-response untuk WhatsApp simulation
function simulateWhatsAppResponse() {
  setTimeout(() => {
    alert(
      "Fitur WhatsApp terintegrasi! Dalam implementasi nyata, ini akan mengirim pesan ke nomor WhatsApp desa untuk mendapat respons otomatis tentang persuratan."
    );
  }, 1000);
}

// Easter egg untuk demo
let clickCount = 0;
document.querySelector(".logo").addEventListener("click", function () {
  clickCount++;
  if (clickCount >= 5) {
    alert(
      "🎉 Selamat! Anda telah menemukan easter egg. Website desa ini dibuat dengan teknologi modern untuk melayani masyarakat dengan lebih baik!"
    );
    clickCount = 0;
  }
});

// Inisialisasi
document.addEventListener("DOMContentLoaded", function () {
  console.log("Website Desa Maju Bersama siap digunakan!");
  console.log(
    "Jangan lupa ganti GEMINI_API_KEY dengan API key yang valid untuk fitur AI"
  );
});
