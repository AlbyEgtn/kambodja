<!DOCTYPE html>
<html lang="id">
<head>
<meta charset="UTF-8" />
<meta name="viewport" content="width=device-width, initial-scale=1.0" />
<title>Dashboard Karyawan</title>

<style>
    body {
        margin: 0;
        padding: 0;
        background: #f5f7fa;
        font-family: 'Segoe UI', sans-serif;
    }

    header {
        background:#004d40;
        color:#fff;
        padding:15px;
        text-align:center;
        font-size:22px;
        width:100%;
    }

    nav {
        width: 100%;
        background:#00695c;
        padding:12px 20px;
        display:flex;
        justify-content:flex-start;
        align-items:center;
        gap:25px;
        box-sizing:border-box;
        color:white;
    }

    nav a {
        color:white;
        text-decoration:none;
        font-size:15px;
        font-weight:500;
    }

    nav a:hover {
        text-decoration:underline;
    }

    .nav-active {
        text-decoration:underline;
        font-weight:600;
    }

    .container {
        padding:30px;
        max-width:900px;
        margin:auto;
    }
</style>

</head>
<body>


@include('components.navbar-karyawan')

<div class="container">
    <!-- AREA KOSONG (POLOS) -->
</div>

</body>
</html>
