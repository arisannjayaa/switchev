<!doctype html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>Jadwal Verifikasi Zoom</title>
    <style>
        /* Styling untuk container */
        body {
            font-family: Arial, sans-serif;
            background-color: #f4f4f9;
            margin: 0;
            padding: 0;
            display: flex;
            justify-content: center;
            align-items: center;
            height: 100vh;
        }

        /* Styling untuk card */
        .card {
            background-color: #fff;
            border-radius: 8px;
            box-shadow: 0 4px 8px rgba(0, 0, 0, 0.1);
            width: 80%;
            max-width: 600px;
            padding: 20px;
            margin: 20px;
        }

        /* Styling untuk card header */
        .card-header {
            font-size: 1.5rem;
            font-weight: bold;
            color: #333;
            margin-bottom: 15px;
            border-bottom: 2px solid #f1f1f1;
            padding-bottom: 10px;
        }

        /* Styling untuk teks dalam card */
        .card-body p {
            font-size: 1rem;
            color: #555;
            margin-bottom: 10px;
        }

        /* Styling untuk link */
        .card-body a {
            color: #007bff;
            text-decoration: none;
        }

        .card-body a:hover {
            text-decoration: underline;
        }
    </style>
</head>
<body>
<div class="card">
    <div class="card-header">
        Informasi Rapat Zoom
    </div>
    <div class="card-body">
        {!! $data['message'] !!}
    </div>
</div>
</body>
</html>
