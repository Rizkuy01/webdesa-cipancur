const GEMINI_API_KEY = 'YOUR_GEMINI_API_KEY_HERE';
const GEMINI_API_URL = 'https://generativelanguage.googleapis.com/v1beta/models/gemini-pro:generateContent';

const suratDatabase = {
  // data 'ktp', 'kk', dst. sama seperti dalam file HTML
};

function cariInfoSurat(query) {
  const kata = query.toLowerCase();
  for (let key in suratDatabase) {
    if (kata.includes(key) || kata.includes(suratDatabase[key].nama.toLowerCase())) {
      return suratDatabase[key];
    }
  }
  return null;
}

async function sendMessage() {
  const userInput = document.getElementById('userInput');
  const chatMessages = document.getElementById('chatMessages');
  const loading = document.getElementById('loading');

  if (!userInput.value.trim()) return;

  const userMessage = document.createElement('div');
  userMessage.className = 'message user-message';
  userMessage.innerHTML = `<strong>Anda:</strong> ${userInput.value}`;
  chatMessages.appendChild(userMessage);

  const query = userInput.value;
  userInput.value = '';
  loading.style.display = 'block';
  chatMessages.scrollTop = chatMessages.scrollHeight;

  try {
    const infoSurat = cariInfoSurat(query);
    let response;

    if (infoSurat) {
      response = `📋 **${infoSurat.nama}**\n\n` +
        `**Persyaratan:**\n${infoSurat.syarat.map(s => `• ${s}`).join('\n')}\n\n` +
        `**Prosedur:** ${infoSurat.prosedur}\n\n` +
        `**Waktu Pengurusan:** ${infoSurat.waktu}\n\n` +
        `**Biaya:** ${infoSurat.biaya}`;
    } else {
      response = await getGeminiResponse(query);
    }

    const aiMessage = document.createElement('div');
    aiMessage.className = 'message ai-message';
    aiMessage.innerHTML = `<strong>🤖 AI Assistant:</strong> ${response.replace(/\n/g, '<br>')}`;
    chatMessages.appendChild(aiMessage);
  } catch (error) {
    console.error(error);
  } finally {
    loading.style.display = 'none';
    chatMessages.scrollTop = chatMessages.scrollHeight;
  }
}

async function getGeminiResponse(query) {
  const prompt = `Anda adalah asisten AI untuk pelayanan desa...`;

  const response = await fetch(`${GEMINI_API_URL}?key=${GEMINI_API_KEY}`, {
    method: 'POST',
    headers: { 'Content-Type': 'application/json' },
    body: JSON.stringify({
      contents: [{ parts: [{ text: prompt.replace('${query}', query) }] }]
    })
  });

  const data = await response.json();
  return data.candidates[0].content.parts[0].text;
}

function openWhatsApp() {
  const phoneNumber = '6281234567890';
  const message = `Halo, saya ingin bertanya tentang persuratan desa. Bisa dibantu?`;
  const whatsappURL = `https://wa.me/${phoneNumber}?text=${encodeURIComponent(message)}`;
  window.open(whatsappURL, '_blank');
}

document.querySelectorAll('nav a').forEach(anchor => {
  anchor.addEventListener('click', function (e) {
    e.preventDefault();
    const target = document.querySelector(this.getAttribute('href'));
    if (target) {
      target.scrollIntoView({ behavior: 'smooth', block: 'start' });
    }
  });
});

let clickCount = 0;
document.querySelector('.logo').addEventListener('click', function () {
  clickCount++;
  if (clickCount >= 5) {
    alert('🎉 Selamat! Anda menemukan easter egg!');
    clickCount = 0;
  }
});
