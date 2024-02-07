@php
    function cpfOrCnpj(string $value): string
{
    // Remove all characters that are not digits
    $value = preg_replace('/\D/', '', $value);

    // Check the length of the value
    $length = strlen($value);

    // Apply CPF mask if the length is 11, otherwise apply CNPJ mask
    if ($length === 11) {
        return sprintf('%s.%s.%s-%s', substr($value, 0, 3), substr($value, 3, 3), substr($value, 6, 3), substr($value, 9, 2));
    } elseif ($length === 14) {
        return sprintf('%s.%s.%s/%s-%s', substr($value, 0, 2), substr($value, 2, 3), substr($value, 5, 3), substr($value, 8, 4), substr($value, 12, 2));
    } else {
        // Invalid length, return original value
        return $value;
    }
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
            / {{ cpfOrCnpj($doctor->cpf) }}
        @endif</p>
</div>

<p style="text-align: left;line-height: 2;margin-bottom: 2rem;">Recebi do(a) sr(a) {{ $patient->name }},
    CPF {{ cpfOrCnpj($patient->document) }}, a
    quantia de R$ {{ number_format($amount, 2, ',', '.') }} referente a consulta médica em consultório.</p>

<p style="margin-bottom: 2rem;">{{ $date->format('d/m/Y') }}</p>

<p>{{ $addressLine1 }}</p>
<p>{{ $addressLine2 }}</p>

<hr style="width: 60%;margin: 6rem auto 0;">
<p style="font-size: .875rem;text-transform: uppercase;text-align: center;">Assinatura</p>
</body>
</html>
