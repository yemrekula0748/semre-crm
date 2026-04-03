<?php
session_start();
require 'DB.php'; // Veritabanı bağlantısı

$db = new DB();
$error = '';

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $email = $_POST['user_name']; // Dropdown'dan seçilen e-posta
    $password = $_POST['password'];

    try {
        $sql = "SELECT * FROM users WHERE email = '" . $db->escape($email) . "'";
        $result = $db->query($sql);

        if ($db->numRows($result) > 0) {
            $user = $db->fetchAssoc($result);

            if (password_verify($password, $user['password'])) {
                $_SESSION['user_id'] = $user['id'];
                $_SESSION['user_name'] = $user['name'];
                header("Location: index.php"); // Başarılı giriş yapıldıysa yönlendirme
                exit;
            } else {
                $error = "Geçersiz şifre.";
            }
        } else {
            $error = "Kullanıcı bulunamadı.";
        }
    } catch (Exception $e) {
        $error = "Bir hata oluştu: " . $e->getMessage();
    }
}

?>

<?php
// Kullanıcı adlarını almak için veritabanından çek
$userSql = "SELECT name, email FROM users";
$userResult = $db->query($userSql);
$users = [];
while ($row = $db->fetchAssoc($userResult)) {
    $users[] = $row;
}
?>


<!DOCTYPE html>
<html lang="tr">
<head>
    <meta charset="utf-8" />
    <title>Giriş Yap | Sipariş Paneli</title>
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="IE=edge" />
    <script src="https://cdn.tailwindcss.com"></script>
    <script>
        tailwind.config = {
            theme: {
                extend: {
                    fontFamily: { sans: ['Inter', 'ui-sans-serif', 'system-ui'] },
                    colors: {
                        brand: { DEFAULT: '#4f46e5', dark: '#4338ca', light: '#6366f1' }
                    }
                }
            }
        }
    </script>
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@300;400;500;600;700;800&display=swap" rel="stylesheet">
    <style>
        body { font-family: 'Inter', sans-serif; }

        .gradient-panel {
            background: linear-gradient(145deg, #1e1b4b 0%, #312e81 35%, #4338ca 70%, #6366f1 100%);
        }
        .blob {
            position: absolute;
            border-radius: 50%;
            filter: blur(70px);
            opacity: 0.12;
            pointer-events: none;
        }
        .card-shadow { box-shadow: 0 32px 64px -12px rgba(0,0,0,0.22), 0 0 0 1px rgba(0,0,0,0.04); }

        .form-input {
            width: 100%;
            padding: 0.75rem 0.875rem 0.75rem 2.75rem;
            background: #f8fafc;
            border: 1.5px solid #e2e8f0;
            border-radius: 0.75rem;
            font-size: 0.875rem;
            color: #1e293b;
            transition: border-color 0.2s, box-shadow 0.2s, background 0.2s;
            outline: none;
        }
        .form-input:hover { border-color: #a5b4fc; background: #fff; }
        .form-input:focus { border-color: #4f46e5; box-shadow: 0 0 0 3px rgba(99,102,241,0.12); background: #fff; }

        .select-arrow {
            background-image: url("data:image/svg+xml,%3Csvg xmlns='http://www.w3.org/2000/svg' fill='none' viewBox='0 0 20 20'%3E%3Cpath stroke='%239ca3af' stroke-linecap='round' stroke-linejoin='round' stroke-width='1.5' d='M6 8l4 4 4-4'/%3E%3C/svg%3E");
            background-position: right 0.75rem center;
            background-repeat: no-repeat;
            background-size: 1.25rem;
            appearance: none;
            -webkit-appearance: none;
            padding-right: 2.5rem;
        }

        .btn-login {
            width: 100%;
            padding: 0.8rem 1.5rem;
            background: linear-gradient(135deg, #4f46e5 0%, #7c3aed 100%);
            color: #fff;
            font-weight: 600;
            font-size: 0.9rem;
            letter-spacing: 0.025em;
            border-radius: 0.75rem;
            border: none;
            cursor: pointer;
            transition: transform 0.2s, box-shadow 0.2s, background 0.2s;
            display: flex;
            align-items: center;
            justify-content: center;
            gap: 0.5rem;
        }
        .btn-login:hover {
            background: linear-gradient(135deg, #4338ca 0%, #6d28d9 100%);
            transform: translateY(-1px);
            box-shadow: 0 12px 28px rgba(79,70,229,0.38);
        }
        .btn-login:active { transform: translateY(0); }

        .fade-up { animation: fadeUp 0.55s cubic-bezier(0.22,1,0.36,1) both; }
        @keyframes fadeUp {
            from { opacity: 0; transform: translateY(18px); }
            to   { opacity: 1; transform: translateY(0); }
        }

        .float-art { animation: floatArt 4s ease-in-out infinite; }
        @keyframes floatArt {
            0%,100% { transform: translateY(0px); }
            50%      { transform: translateY(-12px); }
        }

        .eye-toggle {
            position: absolute; right: 0.75rem; top: 50%; transform: translateY(-50%);
            background: none; border: none; cursor: pointer;
            color: #9ca3af; padding: 0; line-height: 1;
            transition: color 0.2s;
        }
        .eye-toggle:hover { color: #4f46e5; }

        .feature-pill {
            display: flex; align-items: center; gap: 0.75rem;
            background: rgba(255,255,255,0.08);
            border: 1px solid rgba(255,255,255,0.12);
            border-radius: 0.75rem;
            padding: 0.625rem 1rem;
            backdrop-filter: blur(8px);
        }

        /* Mobile-first responsive tweaks */
        @media (max-width: 1023px) {
            .gradient-panel { padding: 2.5rem 2rem 2rem; }
        }
    </style>
</head>

<body class="min-h-screen bg-slate-100 flex items-center justify-center p-4 lg:p-6">

    <div class="w-full max-w-5xl mx-auto">
        <div class="bg-white rounded-3xl overflow-hidden card-shadow flex flex-col lg:flex-row" style="min-height:600px">

            <!-- ====== LEFT PANEL — Brand ====== -->
            <div class="gradient-panel relative lg:w-5/12 p-10 lg:p-12 flex flex-col justify-between overflow-hidden">

                <!-- Decorative blobs -->
                <div class="blob bg-indigo-300 w-80 h-80 -top-24 -left-24"></div>
                <div class="blob bg-purple-400 w-64 h-64 -bottom-16 -right-16"></div>
                <div class="blob bg-blue-300 w-48 h-48" style="top:45%;left:-30px"></div>

                <!-- Top: Logo & brand -->
                <div class="relative z-10">
                    <div class="flex items-center gap-3 mb-10">
                        <div class="w-10 h-10 rounded-xl flex items-center justify-center" style="background:rgba(255,255,255,0.15);backdrop-filter:blur(8px);">
                            <svg class="w-5 h-5 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                    d="M20 7l-8-4-8 4m16 0l-8 4m8-4v10l-8 4m0-10L4 7m8 4v10M4 7v10l8 4"/>
                            </svg>
                        </div>
                        <span class="text-white font-bold text-lg tracking-wide">SemreCRM</span>
                    </div>

                    <!-- Floating illustration -->
                    <div class="float-art hidden lg:flex justify-center mb-8">
                        <svg viewBox="0 0 220 180" class="w-52 h-auto" fill="none" xmlns="http://www.w3.org/2000/svg">
                            <!-- Main card -->
                            <rect x="20" y="20" width="160" height="130" rx="14" fill="white" fill-opacity="0.1" stroke="white" stroke-opacity="0.25" stroke-width="1.5"/>
                            <!-- Header bar -->
                            <rect x="20" y="20" width="160" height="38" rx="14" fill="white" fill-opacity="0.15"/>
                            <rect x="20" y="44" width="160" height="14" rx="0" fill="white" fill-opacity="0.15"/>
                            <circle cx="40" cy="39" r="6" fill="white" fill-opacity="0.55"/>
                            <rect x="54" y="34" width="60" height="5" rx="3" fill="white" fill-opacity="0.55"/>
                            <rect x="54" y="41" width="40" height="3.5" rx="2" fill="white" fill-opacity="0.3"/>
                            <!-- Row items -->
                            <rect x="32" y="70" width="80" height="5" rx="3" fill="white" fill-opacity="0.45"/>
                            <rect x="32" y="82" width="110" height="4" rx="2" fill="white" fill-opacity="0.25"/>
                            <rect x="32" y="94" width="95" height="4" rx="2" fill="white" fill-opacity="0.25"/>
                            <rect x="32" y="106" width="65" height="4" rx="2" fill="white" fill-opacity="0.25"/>
                            <!-- CTA button -->
                            <rect x="32" y="122" width="68" height="20" rx="7" fill="white" fill-opacity="0.25" stroke="white" stroke-opacity="0.4" stroke-width="1"/>
                            <rect x="46" y="130" width="40" height="4" rx="2" fill="white" fill-opacity="0.7"/>
                            <!-- Badge top-right -->
                            <circle cx="175" cy="55" r="18" fill="white" fill-opacity="0.15" stroke="white" stroke-opacity="0.3" stroke-width="1.5"/>
                            <path d="M167 55 L173 61 L184 48" stroke="white" stroke-opacity="0.85" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"/>
                        </svg>
                    </div>

                    <h2 class="text-white text-2xl lg:text-3xl font-bold leading-snug mb-3">
                        Sipariş Yönetim<br>Panelinize Hoş Geldiniz
                    </h2>
                    <p class="text-indigo-200 text-sm leading-relaxed">
                        Siparişlerinizi kolayca yönetin, takip edin ve raporlayın.<br class="hidden lg:inline">
                        Tüm süreçleriniz tek ekranda.
                    </p>
                </div>

                <!-- Bottom: Feature pills -->
                <div class="relative z-10 mt-10 flex flex-col gap-3 hidden lg:flex">
                    <div class="feature-pill">
                        <svg class="w-4 h-4 text-indigo-200 flex-shrink-0" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z"/>
                        </svg>
                        <span class="text-indigo-100 text-xs font-medium">Anlık sipariş takibi &amp; durum güncellemeleri</span>
                    </div>
                    <div class="feature-pill">
                        <svg class="w-4 h-4 text-indigo-200 flex-shrink-0" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                d="M9 19v-6a2 2 0 00-2-2H5a2 2 0 00-2 2v6a2 2 0 002 2h2a2 2 0 002-2zm0 0V9a2 2 0 012-2h2a2 2 0 012 2v10m-6 0a2 2 0 002 2h2a2 2 0 002-2m0 0V5a2 2 0 012-2h2a2 2 0 012 2v14a2 2 0 01-2 2h-2a2 2 0 01-2-2z"/>
                        </svg>
                        <span class="text-indigo-100 text-xs font-medium">Detaylı raporlama ve analiz araçları</span>
                    </div>
                    <div class="feature-pill">
                        <svg class="w-4 h-4 text-indigo-200 flex-shrink-0" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                d="M12 15v2m-6 4h12a2 2 0 002-2v-6a2 2 0 00-2-2H6a2 2 0 00-2 2v6a2 2 0 002 2zm10-10V7a4 4 0 00-8 0v4h8z"/>
                        </svg>
                        <span class="text-indigo-100 text-xs font-medium">Güvenli ve hızlı kullanıcı erişimi</span>
                    </div>
                </div>
            </div>

            <!-- ====== RIGHT PANEL — Login Form ====== -->
            <div class="lg:w-7/12 bg-white px-8 py-10 lg:px-14 lg:py-0 flex flex-col justify-center fade-up">
                <div class="w-full max-w-sm mx-auto">

                    <!-- Header -->
                    <div class="mb-9">
                        <div class="inline-flex items-center gap-2 bg-indigo-50 text-indigo-600 text-xs font-semibold px-3 py-1.5 rounded-full mb-5">
                            <svg class="w-3.5 h-3.5" fill="currentColor" viewBox="0 0 20 20">
                                <path fill-rule="evenodd" d="M5 9V7a5 5 0 0110 0v2a2 2 0 012 2v5a2 2 0 01-2 2H5a2 2 0 01-2-2v-5a2 2 0 012-2zm8-2v2H7V7a3 3 0 016 0z" clip-rule="evenodd"/>
                            </svg>
                            Güvenli Giriş
                        </div>
                        <h1 class="text-slate-900 text-2xl font-bold mb-1.5">Tekrar Hoş Geldiniz 👋</h1>
                        <p class="text-slate-500 text-sm">Hesabınıza erişmek için bilgilerinizi girin.</p>
                    </div>

                    <!-- Error alert -->
                    <?php if ($error): ?>
                    <div class="mb-6 flex items-start gap-3 bg-red-50 border border-red-200 text-red-700 px-4 py-3 rounded-xl text-sm">
                        <svg class="w-5 h-5 flex-shrink-0 mt-0.5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                d="M12 9v2m0 4h.01m-6.938 4h13.856c1.54 0 2.502-1.667 1.732-3L13.732 4c-.77-1.333-2.694-1.333-3.464 0L3.34 16c-.77 1.333.192 3 1.732 3z"/>
                        </svg>
                        <span><?= htmlspecialchars($error) ?></span>
                    </div>
                    <?php endif; ?>

                    <!-- Form -->
                    <form action="login.php" method="POST" class="space-y-5">

                        <!-- User select -->
                        <div>
                            <label for="user_name" class="block text-sm font-medium text-slate-700 mb-1.5">
                                Kullanıcı Seçin
                            </label>
                            <div class="relative">
                                <span class="absolute inset-y-0 left-0 pl-3 flex items-center pointer-events-none">
                                    <svg class="w-5 h-5 text-slate-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                            d="M16 7a4 4 0 11-8 0 4 4 0 018 0zM12 14a7 7 0 00-7 7h14a7 7 0 00-7-7z"/>
                                    </svg>
                                </span>
                                <select class="form-input select-arrow" id="user_name" name="user_name" required>
                                    <option value="">Kullanıcı seçiniz…</option>
                                    <?php foreach ($users as $user): ?>
                                        <option value="<?= htmlspecialchars($user['email']) ?>">
                                            <?= htmlspecialchars($user['name']) ?>
                                        </option>
                                    <?php endforeach; ?>
                                </select>
                            </div>
                        </div>

                        <!-- Password -->
                        <div>
                            <label for="password" class="block text-sm font-medium text-slate-700 mb-1.5">
                                Şifre
                            </label>
                            <div class="relative">
                                <span class="absolute inset-y-0 left-0 pl-3 flex items-center pointer-events-none">
                                    <svg class="w-5 h-5 text-slate-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                            d="M12 15v2m-6 4h12a2 2 0 002-2v-6a2 2 0 00-2-2H6a2 2 0 00-2 2v6a2 2 0 002 2zm10-10V7a4 4 0 00-8 0v4h8z"/>
                                    </svg>
                                </span>
                                <input
                                    class="form-input"
                                    style="padding-right:2.75rem"
                                    type="password"
                                    id="password"
                                    name="password"
                                    required
                                    placeholder="••••••••"
                                >
                                <button type="button" class="eye-toggle" id="eye-btn" onclick="togglePassword()" aria-label="Şifreyi göster/gizle">
                                    <svg id="eye-icon" class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                            d="M15 12a3 3 0 11-6 0 3 3 0 016 0z"/>
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                            d="M2.458 12C3.732 7.943 7.523 5 12 5c4.478 0 8.268 2.943 9.542 7-1.274 4.057-5.064 7-9.542 7-4.477 0-8.268-2.943-9.542-7z"/>
                                    </svg>
                                </button>
                            </div>
                        </div>

                        <!-- Submit -->
                        <div class="pt-1">
                            <button type="submit" class="btn-login">
                                Giriş Yap
                                <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                        d="M14 5l7 7m0 0l-7 7m7-7H3"/>
                                </svg>
                            </button>
                        </div>

                    </form>

                    <!-- Footer -->
                    <p class="text-center text-xs text-slate-400 mt-10">
                        &copy; <?= date('Y') ?> SemreCRM &middot; Tüm hakları saklıdır.
                    </p>

                </div>
            </div>

        </div>
    </div>

    <script>
        const eyeShowPath = `<path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 12a3 3 0 11-6 0 3 3 0 016 0z"/><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M2.458 12C3.732 7.943 7.523 5 12 5c4.478 0 8.268 2.943 9.542 7-1.274 4.057-5.064 7-9.542 7-4.477 0-8.268-2.943-9.542-7z"/>`;
        const eyeHidePath = `<path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13.875 18.825A10.05 10.05 0 0112 19c-4.478 0-8.268-2.943-9.543-7a9.97 9.97 0 011.563-3.029m5.858.908a3 3 0 114.243 4.243M9.878 9.878l4.242 4.242M9.88 9.88l-3.29-3.29m7.532 7.532l3.29 3.29M3 3l3.59 3.59m0 0A9.953 9.953 0 0112 5c4.478 0 8.268 2.943 9.543 7a10.025 10.025 0 01-4.132 5.411m0 0L21 21"/>`;

        function togglePassword() {
            const input = document.getElementById('password');
            const icon  = document.getElementById('eye-icon');
            const isHidden = input.type === 'password';
            input.type    = isHidden ? 'text' : 'password';
            icon.innerHTML = isHidden ? eyeHidePath : eyeShowPath;
        }
    </script>
</body>
</html>
