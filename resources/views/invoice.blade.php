@php
    function cpf(string $value): string
    {
        return sprintf('%s.%s.%s-%s', substr($value, 0, 3), substr($value, 3, 3), substr($value, 6, 3), substr($value, 9, 2));
    }
@endphp

<!DOCTYPE html>
<html lang="pt-br">
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

<div style="margin-bottom: 2rem;">
    <h2>{{ $doctor->user->name }}</h2>
    <p>{{ $doctor->council_type }}: {{ $doctor->council_number }} @if ($doctor->cpf)
            / CPF: {{ cpf($doctor->cpf) }}
        @endif</p>
</div>

<p style="text-align: left;line-height: 2;margin-bottom: 2rem;">Recebi do(a) sr(a) {{ $patient->name }},
    CPF {{ cpf($patient->document) }}, a
    quantia de R$ {{ number_format($amount, 2, ',', '.') }} referente a consulta médica em consultório.</p>

<p style="margin-bottom: 2rem;">{{ $date->format('d/m/Y') }}</p>

<p>{{ $addressLine1 }}</p>
<p>{{ $addressLine2 }}</p>

<hr style="width: 60%;margin: 6rem auto 0;">
<p style="font-size: .875rem;text-transform: uppercase;text-align: center;">Assinatura</p>
</body>
</html>
