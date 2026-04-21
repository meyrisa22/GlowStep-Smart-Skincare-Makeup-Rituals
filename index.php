<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>GlowStep: Smart Skincare & Makeup Rituals</title>
    <script src="https://cdn.tailwindcss.com"></script>
    <link href="https://fonts.googleapis.com/css2?family=Plus+Jakarta+Sans:wght@400;600;700&display=swap" rel="stylesheet">
    <style>
        body { font-family: 'Plus Jakarta Sans', sans-serif; }
        .glass-card { background: rgba(255, 255, 255, 0.8); backdrop-filter: blur(10px); }
    </style>
</head>
<body class="bg-gradient-to-br from-rose-50 to-indigo-50 min-h-screen flex items-center justify-center p-6">
    <div class="max-w-4xl w-full text-center">
        <header class="mb-12">
            <h1 class="text-4xl md:text-5xl font-bold text-gray-800 mb-4">✨ GlowGuide</h1>
            <p class="text-gray-600 text-lg">Temukan urutan ritual kecantikan yang tepat untuk kulitmu.</p>
        </header>

        <div class="grid md:grid-cols-2 gap-8">
            <a href="skincare.php" class="group relative overflow-hidden bg-white p-8 rounded-3xl shadow-xl transition-all hover:-translate-y-2 hover:shadow-2xl">
                <div class="absolute top-0 right-0 p-4 opacity-10 group-hover:opacity-20 transition-opacity">
                    <svg class="w-24 h-24 text-rose-500" fill="currentColor" viewBox="0 0 24 24"><path d="M12 2C6.48 2 2 6.48 2 12s4.48 10 10 10 10-4.48 10-10S17.52 2 12 2zm0 18c-4.41 0-8-3.59-8-8s3.59-8 8-8 8 3.59 8 8-3.59 8-8 8z"/></svg>
                </div>
                <h2 class="text-2xl font-bold text-gray-800 mb-2">Skincare Routine</h2>
                <p class="text-gray-500 mb-6">Optimalkan penyerapan produk dengan urutan yang benar.</p>
                <span class="inline-flex items-center text-rose-500 font-semibold">
                    Mulai Sekarang 
                    <svg class="w-4 h-4 ml-2" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5l7 7-7 7"></path></svg>
                </span>
            </a>

            <a href="makeup.php" class="group relative overflow-hidden bg-white p-8 rounded-3xl shadow-xl transition-all hover:-translate-y-2 hover:shadow-2xl">
                <div class="absolute top-0 right-0 p-4 opacity-10 group-hover:opacity-20 transition-opacity">
                    <svg class="w-24 h-24 text-indigo-500" fill="currentColor" viewBox="0 0 24 24"><path d="M12 3v10.55c-.59-.34-1.27-.55-2-.55-2.21 0-4 1.79-4 4s1.79 4 4 4 4-1.79 4-4V7h4V3h-6z"/></svg>
                </div>
                <h2 class="text-2xl font-bold text-gray-800 mb-2">Makeup Step</h2>
                <p class="text-gray-500 mb-6">Hasil flawless dengan teknik layering yang tepat.</p>
                <span class="inline-flex items-center text-indigo-500 font-semibold">
                    Atur Produkmu
                    <svg class="w-4 h-4 ml-2" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5l7 7-7 7"></path></svg>
                </span>
            </a>
        </div>
    </div>
</body>
</html>
