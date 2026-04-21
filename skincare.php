<?php
/**
 * Skincare Ritual Guide & 14-Day Smart Planner
 * Versi: Ultra-Modern Luxury dengan Frekuensi Pemakaian
 */

// 1. Daftar Produk Lengkap
$skincare = [
    "Micellar Water" , "Face Wash", "Exfoliate", "Peeling Gel", 
    "Toner", "Essence", "Face Mist", "Serum", 
    "Spot Treatment", "Eye Cream", "Moisturizer", "Cleansing Oil", 
    "Night Cream", "Face Mask", "Sheet Mask", "Sunscreen", 
    "BB Cream", "Primer", "Lip Serum", "Lip Balm", "Lip SPF", "Cleansing Balm"
];

// Urutan aplikasi yang benar
$applyOrder = [
    "Micellar Water" => 0, "Cleansing Oil" => 1, "Cleansing Balm" => 2, "Face Wash" => 3, 
    "Exfoliate" => 4, "Peeling Gel" => 5, "Toner" => 6, "Essence" => 7, 
    "Face Mist" => 8, "Serum" => 9, "Spot Treatment" => 10, "Eye Cream" => 11, 
    "Moisturizer" => 12, "Facial Oil" => 13, "Night Cream" => 14, "Face Mask" => 15, 
    "Sheet Mask" => 16, "Sunscreen" => 17, "BB Cream" => 18, "Primer" => 19, 
    "Lip Serum" => 20, "Lip Balm" => 21, "Lip SPF" => 22
];

$errors = []; $result = []; $dailyRoutine = [];
$count = 0; $show_dropdowns = false;
$action = $_POST['action'] ?? '';

// 2. Logika Pemrosesan
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    if ($action === 'generate') {
        $count = intval($_POST['count'] ?? 0);
        if ($count < 1 || $count > count($applyOrder)) { 
            $errors[] = "Masukkan jumlah yang valid."; 
        } else { 
            $show_dropdowns = true; 
        }
    } elseif ($action === 'process') {
        $count = intval($_POST['count'] ?? 0);
        $raw = $_POST['product'] ?? [];
        $clean = array_values(array_unique(array_filter($raw)));

        foreach ($clean as $val) {
            if (isset($applyOrder[$val])) {
                $result[] = ['order' => $applyOrder[$val], 'name' => $val];
            }
        }
        usort($result, fn($a, $b) => $a['order'] <=> $b['order']);

        // Generate Jadwal 14 Hari (Smart Frequency)
        if (!empty($result)) {
            for ($day = 1; $day <= 14; $day++) {
                // Produk berat muncul tiap 3 hari sekali (Hari 1, 4, 7, 10, 13)
                $isSpecialDay = ($day % 3 == 1); 
                
                // Filter Pagi: Hapus produk malam & eksfoliasi/masker
                $morning = array_filter($result, fn($r) => 
                    !in_array($r['name'], ['Night Cream', 'Face Mask', 'Sheet Mask', 'Cleansing Oil', 'Cleansing Balm', 'Micellar Water', 'Peeling Gel', 'Exfoliate'])
                );

                // Filter Malam: Atur produk eksfoliasi agar tidak muncul setiap hari
                $night = array_filter($result, function($r) use ($isSpecialDay) {
                    $specialProducts = ['Exfoliate', 'Peeling Gel', 'Face Mask', 'Sheet Mask'];
                    
                    // Jika bukan hari spesial, hapus produk berat
                    if (!$isSpecialDay && in_array($r['name'], $specialProducts)) {
                        return false;
                    }
                    // Hapus produk pagi dari jadwal malam
                    return !in_array($r['name'], ['Sunscreen', 'BB Cream', 'Primer', 'Lip SPF']);
                });
                
                $dailyRoutine[$day] = [
                    'am' => $morning,
                    'pm' => $night,
                    'is_special' => $isSpecialDay
                ];
            }
        }
    }
}
?>
<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Skincare Planner | Glow Ritual</title>
    <script src="https://cdn.tailwindcss.com"></script>
    <link href="https://fonts.googleapis.com/css2?family=Marcellus&family=Plus+Jakarta+Sans:wght@300;400;600&display=swap" rel="stylesheet">
    <style>
        body { font-family: 'Plus Jakarta Sans', sans-serif; background-color: #fdf8f6; color: #1e293b; }
        .serif { font-family: 'Marcellus', serif; }
        .glass { background: rgba(255, 255, 255, 0.7); backdrop-filter: blur(12px); border: 1px solid rgba(255, 255, 255, 0.4); }
        .step-number { background: linear-gradient(135deg, #fb7185, #e11d48); }
        @media print { .no-print { display: none; } body { background: white; } }
    </style>
</head>
<body class="min-h-screen relative overflow-x-hidden">
    
    <div class="absolute -top-40 -left-40 w-[500px] h-[500px] bg-rose-100 rounded-full blur-[120px] opacity-60 no-print"></div>

    <nav class="max-w-6xl mx-auto p-8 flex justify-between items-center relative z-10 no-print">
        <a href="index.php" class="text-2xl serif tracking-tight">GLOW<span class="text-rose-500">.</span></a>
        <a href="index.php" class="text-xs font-bold uppercase tracking-[0.2em] text-slate-400">Back</a>
    </nav>

    <main class="max-w-6xl mx-auto px-6 py-10 relative z-10">
        
        <?php if (!empty($result)): ?>
            <div class="grid lg:grid-cols-12 gap-12 mb-24 animate-in fade-in duration-1000">
                <div class="lg:col-span-4 no-print">
                    <div class="sticky top-10 glass p-10 rounded-[3rem] text-center shadow-2xl shadow-rose-100">
                        <h2 class="text-2xl serif mb-2">Master Order</h2>
                        <p class="text-xs text-slate-400 mb-8 uppercase tracking-widest">Urutan Layering Produk</p>
                        <div class="p-4 bg-rose-500 text-white rounded-2xl text-xs font-bold">
                            <?= count($result) ?> Produk Terpilih
                        </div>
                        <a href="skincare.php" class="block mt-8 text-xs font-bold underline text-rose-400">Ulangi Analisis</a>
                    </div>
                </div>

                <div class="lg:col-span-8 space-y-4">
                    <?php foreach ($result as $index => $r): ?>
                        <div class="flex items-center gap-6 p-4 bg-white/50 rounded-3xl border border-white shadow-sm">
                            <div class="step-number w-12 h-12 shrink-0 rounded-2xl flex items-center justify-center text-white text-xl serif">
                                <?= $index + 1 ?>
                            </div>
                            <span class="text-lg font-medium"><?= htmlspecialchars($r['name']) ?></span>
                        </div>
                    <?php endforeach; ?>
                </div>
            </div>

            <section class="animate-in slide-in-from-bottom-10 duration-1000">
                <div class="text-center mb-12">
                    <h2 class="serif text-4xl mb-3">14-Day <span class="italic text-rose-500">Smart Calendar</span></h2>
                    <p class="text-slate-400 max-w-md mx-auto text-sm">Produk aktif/eksfoliasi telah diatur secara otomatis agar tidak merusak skin barrier.</p>
                </div>

                <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-7 gap-4">
                    <?php foreach ($dailyRoutine as $day => $routine): ?>
                        <div class="glass p-5 rounded-[2.5rem] border-2 transition-all <?= $routine['is_special'] ? 'border-rose-300 bg-rose-50/50' : 'border-rose-50' ?>">
                            <div class="text-center mb-4">
                                <span class="text-[9px] font-bold text-slate-300 uppercase tracking-widest">Day</span>
                                <h3 class="text-2xl serif <?= $routine['is_special'] ? 'text-rose-500' : 'text-slate-700' ?>"><?= $day ?></h3>
                                <?php if ($routine['is_special']): ?>
                                    <span class="text-[7px] px-2 py-0.5 bg-rose-500 text-white rounded-full font-bold uppercase">Treatment</span>
                                <?php endif; ?>
                            </div>
                            
                            <div class="space-y-3">
                                <div class="p-2 bg-orange-50/50 rounded-xl border border-orange-100">
                                    <span class="text-[8px] font-bold text-orange-400 block mb-1 uppercase">AM</span>
                                    <ul class="text-[9px] text-slate-500 leading-tight">
                                        <?php foreach ($routine['am'] as $item): ?>
                                            <li class="truncate">• <?= $item['name'] ?></li>
                                        <?php endforeach; ?>
                                    </ul>
                                </div>
                                <div class="p-2 bg-indigo-50/50 rounded-xl border border-indigo-100">
                                    <span class="text-[8px] font-bold text-indigo-400 block mb-1 uppercase">PM</span>
                                    <ul class="text-[9px] text-slate-500 leading-tight">
                                        <?php foreach ($routine['pm'] as $item): ?>
                                            <li class="truncate">• <?= $item['name'] ?></li>
                                        <?php endforeach; ?>
                                    </ul>
                                </div>
                            </div>
                        </div>
                    <?php endforeach; ?>
                </div>

                <div class="mt-12 text-center no-print">
                    <button onclick="window.print()" class="px-10 py-4 bg-slate-900 text-white rounded-full font-bold text-xs uppercase tracking-widest hover:bg-rose-600 transition-all">
                        Cetak Jadwal Saya
                    </button>
                </div>
            </section>

        <?php elseif (!$show_dropdowns): ?>
            <div class="max-w-md mx-auto glass p-12 rounded-[3rem] shadow-2xl text-center">
                <form method="POST">
                    <h3 class="serif text-2xl mb-2">Skin Inventory</h3>
                    <p class="text-slate-400 text-sm mb-8">Berapa banyak produk yang Anda gunakan?</p>
                    <input type="number" name="count" min="1" max="22" class="w-full text-7xl serif text-center bg-transparent border-b-2 border-rose-100 focus:border-rose-500 focus:outline-none mb-10" placeholder="0" required>
                    <button type="submit" name="action" value="generate" class="w-full py-5 bg-slate-900 text-white rounded-2xl font-bold uppercase tracking-widest text-xs hover:bg-rose-600 transition-all">Lanjut</button>
                </form>
            </div>

        <?php else: ?>
            <div class="max-w-2xl mx-auto glass p-10 rounded-[3rem] shadow-2xl">
                <form method="POST" class="space-y-6">
                    <input type="hidden" name="count" value="<?= $count ?>">
                    <h3 class="serif text-center text-3xl mb-8">Pilih Koleksi Anda</h3>
                    <div class="grid gap-4">
                        <?php for ($i=0; $i<$count; $i++): ?>
                            <select name="product[]" class="w-full p-4 bg-white/80 border border-slate-100 rounded-2xl appearance-none focus:ring-2 focus:ring-rose-400 focus:outline-none font-medium cursor-pointer" required>
                                <option value="">-- Pilih Produk #<?= $i+1 ?> --</option>
                                <?php 
                                $sorted = $skincare; sort($sorted);
                                foreach ($sorted as $s): 
                                ?>
                                    <option value="<?= $s ?>"><?= $s ?></option>
                                <?php endforeach; ?>
                            </select>
                        <?php endfor; ?>
                    </div>
                    <div class="grid grid-cols-2 gap-4 pt-6">
                        <button type="button" onclick="window.location='skincare.php'" class="py-4 font-bold text-slate-400 uppercase tracking-widest text-xs">Reset</button>
                        <button type="submit" name="action" value="process" class="py-4 bg-rose-500 text-white rounded-2xl font-bold uppercase tracking-widest text-xs shadow-lg shadow-rose-200">Buat Jadwal</button>
                    </div>
                </form>
            </div>
        <?php endif; ?>
    </main>

    <footer class="text-center py-12 text-slate-300 text-[10px] uppercase tracking-[0.3em] font-bold">
        &copy; 2025 GLOW. Personal Beauty Concierge
    </footer>
</body>
</html>