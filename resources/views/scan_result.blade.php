<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>QR Scan Result</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">
</head>
<body class="bg-light">

<div class="container text-center mt-5">
    <div class="card shadow-lg p-4 mx-auto" style="max-width: 450px;">
        <h2 class="text-success mb-4">✅ QR Code Scanned Successfully</h2>
        <p><strong>Roll Number:</strong> {{ $roll }}</p>
        <p><strong>Name:</strong> {{ $name }} {{ $lastname }}</p>
        <p><strong>Center:</strong> {{ $center }}</p>
        <hr>
        <p class="text-muted small">© {{ date('Y') }} Admit Card Verification System</p>
    </div>
</div>

</body>
</html>
