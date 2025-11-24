<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Login - Sistem Kasir Kambojda</title>

    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@300;400;500;600&display=swap" rel="stylesheet">

    <style>
        body {
            margin: 0;
            font-family: 'Inter', sans-serif;
            background: #f0f4f3;
            display: flex;
            justify-content: center;
            align-items: center;
            height: 100vh;
        }

        .login-container {
            width: 420px;
            background: #fff;
            padding: 35px;
            border-radius: 14px;
            box-shadow: 0 6px 22px rgba(0,0,0,0.08);
        }

        .title {
            font-size: 24px;
            font-weight: 600;
            text-align: center;
            color: #00695c;
            margin-bottom: 8px;
        }

        .subtitle {
            font-size: 14px;
            text-align: center;
            color: #6b6b6b;
            margin-bottom: 25px;
        }

        label {
            font-weight: 500;
            margin-bottom: 5px;
            display: block;
            color: #333;
            font-size: 14px;
        }

        input {
            width: 100%;
            padding: 11px;
            border-radius: 8px;
            border: 1px solid #cfcfcf;
            font-size: 14px;
            margin-bottom: 18px;
        }

        input:focus {
            border-color: #009688;
            outline: none;
            box-shadow: 0 0 5px rgba(0,150,136,0.25);
        }

        .btn-login {
            width: 100%;
            background: #00796b;
            padding: 12px;
            border: none;
            border-radius: 8px;
            color: #fff;
            font-weight: 600;
            font-size: 15px;
            cursor: pointer;
            transition: 0.2s ease;
        }

        .btn-login:hover {
            background: #005a4f;
        }

        .alert {
            background: #ffebee;
            border-left: 4px solid #d32f2f;
            padding: 12px;
            margin-bottom: 18px;
            border-radius: 4px;
            color: #b71c1c;
            font-size: 14px;
        }
    </style>

</head>

<body>

    <div class="login-container">

        <div class="title">Kambojda</div>
        <div class="subtitle">Silakan login untuk melanjutkan</div>

        @if ($errors->any())
            <div class="alert alert-danger" id="rate-limit-message">
                {{ $errors->first() }}
            </div>
        @endif

        <form action="{{ route('login.process') }}" method="POST">
            @csrf

            <label>Username</label>
            <input type="text" name="username" placeholder="Masukkan username..." required>

            <label>Password</label>
            <input type="password" name="password" placeholder="Masukkan password..." required>

            <button class="btn-login" type="submit">Login</button>
        </form>

    </div>
<script>
    document.addEventListener('DOMContentLoaded', function () {
    const el = document.getElementById('rate-limit-message');
    if (!el) return;

    let text = el.innerText;

    // Cari angka detik dari pesan (misalnya "45")
    let match = text.match(/(\d+)\s*detik/);

    if (match) {
        let seconds = parseInt(match[1]);

        let interval = setInterval(() => {
            seconds--;

            if (seconds <= 0) {
                clearInterval(interval);
                el.innerText = "Silakan coba login kembali sekarang.";
                return;
            }

            // Update text setiap detik
            el.innerText = `Terlalu banyak percobaan login. Silakan coba lagi dalam ${seconds} detik.`;

        }, 1000);
    }
});
</script>

</body>
</html>
