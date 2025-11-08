<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <title>Dictamen de Certificación</title>
    <style>
        body { font-family: 'DejaVu Sans', sans-serif; margin: 40px; }
        .header { display: flex; justify-content: space-between; align-items: center; }
        .logos img { height: 80px; }
        h2 { text-align: center; margin-top: 20px; }
        p { text-align: justify; font-size: 14pt; line-height: 1.6; }
        .footer { text-align: center; margin-top: 50px; font-size: 12pt; }
    </style>
</head>
<body>
    <div class="header">
        <div class="logos">
            <img src="{{ public_path('images/logoCoordinacion.png') }}" alt="Coordinación de Inglés">
            <img src="{{ public_path('images/logoUttec.png') }}" alt="UTTEC">
        </div>
    </div>

    <h2><b>DICTAMEN DE CERTIFICACIÓN DE INGLÉS</b></h2>

    <p>
        La <b>Universidad Tecnológica de Tecámac</b>, a través de la <b>Coordinación de Inglés</b>,
        certifica que <b>{{ $certificacion->nombre }}</b>, con matrícula <b>{{ $certificacion->matricula }}</b>,
        ha acreditado satisfactoriamente el nivel <b>{{ $certificacion->nivel_in }}</b> correspondiente a su formación
        académica en la carrera de <b>{{ $certificacion->division }}</b>.
    </p>

    <p>
        Este dictamen se emite en reconocimiento al cumplimiento de los requisitos de competencia lingüística
        establecidos por la Coordinación de Inglés, de acuerdo con los lineamientos institucionales vigentes.
    </p>

    <div class="footer">
        <p><b>Coordinación de Inglés</b><br>
        Universidad Tecnológica de Tecámac<br>
        Tecámac, Estado de México</p>
    </div>
</body>
</html>
