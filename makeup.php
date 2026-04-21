<?php
// makeup.php - Logic tetap sama sesuai source
$makeup = ["Primer", "Foundation", "Concealer", "Setting Powder", "Contour", "Blush", "Highlighter", "Eyebrow Pencil", "Eyeshadow", "Eyeliner", "Mascara", "False Lashes", "Lip Liner", "Lipstick", "Lip Gloss", "Setting Spray", "Bronzer", "BB Cream", "CC Cream", "Tinted Moisturizer"];
shuffle($makeup); //

$applyOrder = [
    "Primer" => 0, "BB Cream" => 1, "CC Cream" => 2, "Tinted Moisturizer" => 3, "Foundation" => 4, 
    "Concealer" => 5, "Setting Powder" => 6, "Contour" => 7, "Bronzer" => 8, "Blush" => 9, 
    "Highlighter" => 10, "Eyebrow Pencil" => 11, "Eyeshadow" => 12, "Eyeliner" => 13, 
    "Mascara" => 14, "False Lashes" => 15, "Lip Liner" => 16, "Lipstick" => 17, 
    "Lip Gloss" => 18, "Setting Spray" => 19
]; //

$errors = []; $result = []; $count = 0; $show_dropdowns = false;
$action = $_POST['action'] ?? '';

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    if ($action === 'generate') {
        $count = intval($_POST['count'] ?? 0);
        if ($count < 1 || $count > count($applyOrder)) { $errors[] = "Pilih jumlah yang valid."; } 
        else { $show_dropdowns = true; }
    } elseif ($action === 'process') {
        $count = intval($_POST['count'] ?? 0);
        $raw = $_POST['product'] ?? [];
        $clean = array_values(array_unique(array_filter($raw)));
        foreach ($clean as $val) {
            if (isset($applyOrder[$val])) { $result[] = ['order' => $applyOrder[$val], 'name' => $val]; }
        }
        usort($result, fn($a, $b) => $a['order'] <=> $b['order']);
    }
}
?>
<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Makeup Masterclass | Order Guide</title>
    <script src="https://cdn.tailwindcss.com"></script>
    <link href="https://fonts.googleapis.com/css2?family=Marcellus&family=Plus+Jakarta+Sans:wght@300;400;600&display=swap" rel="stylesheet">
    <style>
        :root { --accent: #6366f1; }
        body { font-family: 'Plus Jakarta Sans', sans-serif; transition: all 0.3s ease; }
        .serif { font-family: 'Marcellus', serif; }
        .glass { background: rgba(255, 255, 255, 0.7); backdrop-filter: blur(12px); border: 1px solid rgba(255, 255, 255, 0.3); }
        .gradient-text { background: linear-gradient(45deg, #6366f1, #a855f7); -webkit-background-clip: text; -webkit-text-fill-color: transparent; }
        .step-card:hover { transform: scale(1.02); }
    </style>
</head>
<body class="bg-[#fcfcfd] text-slate-900 min-h-screen relative overflow-x-hidden">
    
    <div class="absolute -top-24 -right-24 w-96 h-96 bg-indigo-100 rounded-full blur-3xl opacity-50"></div>
    <div class="absolute top-1/2 -left-24 w-72 h-72 bg-purple-100 rounded-full blur-3xl opacity-50"></div>

    <nav class="max-w-5xl mx-auto p-8 flex justify-between items-center relative z-10">
        <a href="index.php" class="font-bold tracking-tighter text-2xl serif">GLOW<span class="text-indigo-600">.</span></a>
        <a href="index.php" class="text-sm font-semibold uppercase tracking-widest text-slate-400 hover:text-indigo-600 transition-colors">Back Home</a>
    </nav>

    <main class="max-w-4xl mx-auto px-6 py-12 relative z-10">
        <header class="mb-16 text-center">
            <h1 class="text-5xl md:text-6xl serif mb-6">Art of <span class="gradient-text">Layering</span></h1>
            <p class="max-w-md mx-auto text-slate-500 leading-relaxed">Pilih produk makeup yang kamu gunakan, dan kami akan menyusun ritual aplikasi yang paling sempurna.</p>
        </header>

        <?php if (!empty($result)): ?>
            <div class="grid md:grid-cols-5 gap-8 animate-in slide-in-from-bottom-8 duration-700">
                <div class="md:col-span-2">
                    <div class="sticky top-8 bg-indigo-600 text-white p-10 rounded-[2rem] shadow-2xl shadow-indigo-200">
                        <h2 class="text-3xl serif mb-4">Your Ritual</h2>
                        <p class="opacity-80 text-sm leading-relaxed">Urutan ini dirancang untuk memastikan produk menempel sempurna dan tahan lama di wajah.</p>
                        <div class="mt-8 pt-8 border-t border-white/20 text-xs uppercase tracking-widest font-bold">Total: <?= count($result) ?> Steps</div>
                    </div>
                </div>
                <div class="md:col-span-3 space-y-4">
                    <?php foreach ($result as $index => $r): ?>
                        <div class="glass p-6 rounded-2xl flex items-center gap-6 step-card transition-all shadow-sm">
                            <span class="text-4xl font-light text-indigo-200 serif italic">0<?= $index + 1 ?></span>
                            <div class="h-8 w-[1px] bg-slate-200"></div>
                            <span class="text-lg font-semibold tracking-tight"><?= htmlspecialchars($r['name']) ?></span>
                        </div>
                    <?php endforeach; ?>
                    <div class="pt-6">
                        <a href="makeup.php" class="inline-block px-8 py-4 border-2 border-slate-200 rounded-full font-bold hover:bg-slate-900 hover:text-white transition-all">Create New Guide</a>
                    </div>
                </div>
            </div>

        <?php elseif (!$show_dropdowns): ?>
            <div class="max-w-md mx-auto glass p-12 rounded-[2.5rem] shadow-xl border-white">
                <form method="POST" class="space-y-8">
                    <div class="text-center">
                        <label class="block text-sm font-bold uppercase tracking-[0.2em] text-slate-400 mb-6">How many products?</label>
                        <input type="number" name="count" min="1" max="20" class="w-full text-6xl serif text-center bg-transparent border-b-2 border-slate-100 focus:border-indigo-500 focus:outline-none pb-4 transition-colors" placeholder="0" required>
                    </div>
                    <button type="submit" name="action" value="generate" class="w-full py-5 bg-slate-900 text-white rounded-2xl font-bold hover:shadow-xl hover:-translate-y-1 transition-all">Next Step</button>
                </form>
            </div>

        <?php else: ?>
            <div class="max-w-2xl mx-auto glass p-10 rounded-[2.5rem] shadow-xl">
                <form method="POST" class="space-y-6">
                    <input type="hidden" name="count" value="<?= $count ?>">
                    <h3 class="text-2xl serif mb-8 text-center uppercase tracking-widest">Select Your Vanity</h3>
                    <div class="grid grid-cols-1 gap-4">
                        <?php for ($i=0; $i<$count; $i++): ?>
                            <div class="relative group">
                                <select name="product[]" class="w-full p-4 bg-white/50 border border-slate-100 rounded-xl appearance-none focus:ring-2 focus:ring-indigo-500 focus:outline-none transition-all cursor-pointer font-medium" required>
                                    <option value="">Slot <?= $i+1 ?>: Choose Product</option>
                                    <?php foreach ($makeup as $m): ?>
                                        <option value="<?= $m ?>"><?= $m ?></option>
                                    <?php endforeach; ?>
                                </select>
                                <div class="absolute right-4 top-1/2 -translate-y-1/2 pointer-events-none opacity-30">
                                    <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path d="M19 9l-7 7-7-7"></path></svg>
                                </div>
                            </div>
                        <?php endfor; ?>
                    </div>
                    <div class="pt-6 grid grid-cols-2 gap-4">
                        <button type="button" onclick="window.location='makeup.php'" class="py-4 border border-slate-200 rounded-xl font-bold text-slate-400 hover:bg-slate-50 transition-all">Reset</button>
                        <button type="submit" name="action" value="process" class="py-4 bg-indigo-600 text-white rounded-xl font-bold shadow-lg shadow-indigo-100 hover:bg-indigo-700 transition-all">Generate My Order</button>
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