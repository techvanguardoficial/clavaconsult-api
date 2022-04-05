<!DOCTYPE html>
<html>
<head>
    <meta charset="UTF-8">
    <title>Recibo</title>

    <style>
        body {
            font-family: sans-serif;
            text-align: center;
        }
        h1 {
            text-transform: uppercase;
        }
    </style>
</head>
<body>
    <h1>Recibo</h1>

    <div style="margin-bottom: 4rem;">
        <h2>{{ $doctor->user->name }}</h2>
        <p>CRM: {{ $doctor->council_number }}@if ($doctor->cpf) / CPF: {{ number_format(substr($doctor->cpf, 0, 9) . '.' . substr($doctor->cpf, 9, 2), 2, '-', '.') }}@endif</p>
    </div>

    <p style="text-align: left;font-size: 20px; line-height: 2;margin-bottom: 8rem;">Recebi do(a) sr(a) {{ $patient->name }}, CPF {{ number_format(substr($patient->document, 0, 9) . '.' . substr($patient->document, 9, 2), 2, '-', '.') }}, a quantia de R$ {{ number_format($amount, 2, ',', '.') }} referente a consulta médica em consultório.</p>

    <p style="margin-bottom: 2rem;">{{ $date->format('d/m/Y') }}</p>

    <p>Endereço aqui</p>
</body>
</html>
