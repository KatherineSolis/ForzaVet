<html>

<head>
    <title>Cita agendada</title>
</head>

<body>
    <h3>Estimado(a) {{ $details['name'] }}</h3>
    <h4>Se ha agendado una cita para la siguiente fecha y hora: </h4>
    <p>{{ $details['fecha_cita'] }} {{ $details['hora_cita'] }}</p>
    <br>
    <b>
        <p>Cualquier duda comunicarse con ....</p>
        <p>Saludos cordiales</p>
    </b>

</body>

</html>