<?php
session_start();
require __DIR__ . '/db.php';

$error = "";

if ((!isset($_SESSION['login']) || $_SESSION['login'] !== true) && isset($_COOKIE['remember_login'])) {
    try {
        $rememberUser = dbOne('SELECT id, username FROM users WHERE username = :username LIMIT 1', [
            ':username' => $_COOKIE['remember_login'],
        ]);

        if ($rememberUser !== null) {
            $_SESSION['login'] = true;
            $_SESSION['username_login'] = $rememberUser['username'];
        }
    } catch (Throwable $exception) {
        $error = 'Database belum siap. Jalankan SQL setup terlebih dahulu.';
    }
}

if(isset($_SESSION['login']) && $_SESSION['login'] == true){
    header('Location: index.php');
    exit();
}

if($_SERVER['REQUEST_METHOD' ] == "POST"){
    $username = trim($_POST['username'] ?? '');
    $password = (string) ($_POST['password'] ?? '');

    try {
        $user = dbOne('SELECT id, username, password FROM users WHERE username = :username LIMIT 1', [
            ':username' => $username,
        ]);

        $isPasswordValid = $user !== null && (
            password_verify($password, $user['password']) || hash_equals($user['password'], $password)
        );

        if ($isPasswordValid) {
            $_SESSION['login'] = true;
            $_SESSION['username_login'] = $user['username'];

            if (isset($_POST['remember'])) {
                setcookie('remember_login', $user['username'], time() + (60 * 60 * 24 * 30), '/');
            } else {
                setcookie('remember_login', '', time() - 3600, '/');
            }

            header('Location: index.php');
            exit();
        }

        $error = "Login gagal!";
    } catch (Throwable $exception) {
        $error = 'Database belum siap. Jalankan SQL setup terlebih dahulu.';
    }
}
?>
<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Login - EduFlow</title>
    <link rel="stylesheet" href="./public/style/output.css">
    <style>
        @import url('https://fonts.googleapis.com/css2?family=Plus+Jakarta+Sans:wght@300;400;500;600;700&display=swap');
        body { font-family: 'Plus+Jakarta+Sans', sans-serif; }
    </style>
</head>
<body class="bg-slate-100 text-slate-900 min-h-screen flex items-center justify-center p-6 bg-[radial-gradient(circle_at_top_right,_var(--tw-gradient-stops))] from-slate-300 via-slate-100 to-slate-50">
    <div class="w-full max-w-[440px]">
        <div class="bg-white/90 backdrop-blur-xl rounded-4xl shadow-2xl shadow-slate-300/40 p-10 border border-slate-200">
            <div class="flex flex-col items-center mb-10">
                <div class="w-16 h-16 bg-slate-900 rounded-2xl flex items-center justify-center text-white shadow-md">
                <svg xmlns="http://www.w3.org/2000/svg" class="w-6 h-6" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 14l9-5-9-5-9 5 9 5z" /><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 14l6.16-3.422a12.083 12.083 0 01.665 6.479A11.952 11.952 0 0012 20.055a11.952 11.952 0 00-6.824-2.998 12.078 12.078 0 01.665-6.479L12 14z" /></svg>
            </div>
                <h1 class="text-3xl font-extrabold tracking-tight text-slate-800">Management Mahasiswa</h1>
                <p class="text-slate-500 mt-2 font-medium text-center">Masuk untuk mengelola data mahasiswa</p>
            </div>

            <?php if (!empty($error)): ?>
                <div class="mb-4 rounded-2xl bg-red-500 text-white px-4 py-3 text-sm font-semibold text-center">
                    <?= htmlspecialchars($error, ENT_QUOTES, 'UTF-8') ?>
                </div>
            <?php endif; ?>
            
            <form action="login.php" method="post" class="space-y-8">
                <div class="space-y-2">
                    <label class="text-sm font-semibold text-slate-700 ml-1">Username</label>
                    <input type="text" name="username" placeholder="Masukkan username" class="w-full px-5 py-4 rounded-2xl bg-white border border-slate-200 focus:border-slate-500 focus:ring-4 focus:ring-slate-500/10 outline-none transition-all">
                </div>
                <div class="space-y-2">
                    <label class="text-sm font-semibold text-slate-700 ml-1">Password</label>
                    <input type="password" name="password" placeholder="••••••••" class="w-full px-5 py-4 rounded-2xl bg-white border border-slate-200 focus:border-slate-500 focus:ring-4 focus:ring-slate-500/10 outline-none transition-all">
                </div>
                <div class="flex items-center justify-between px-1">
                    <label class="flex items-center cursor-pointer group">
                        <input type="checkbox" name="remember" class="w-5 h-5 rounded-lg border-slate-300 text-slate-900 focus:ring-slate-500 cursor-pointer">
                        <span class="ml-3 text-sm font-medium text-slate-600 group-hover:text-slate-900 transition-colors">Ingat Saya</span>
                    </label>
                </div>
                <button type="submit" class="w-full bg-slate-900 hover:bg-slate-700 text-white font-bold py-4 rounded-2xl transition-all shadow-xl shadow-slate-300 hover:-translate-y-1">
                    Masuk Sekarang
                </button>
            </form>
        </div>
    </div>
</body>
</html>