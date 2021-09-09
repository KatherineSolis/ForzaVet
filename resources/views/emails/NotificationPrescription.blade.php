<html>

<head>
    <title>Receta</title>
</head>

<body>
    <h3>Estimado(a) {{ $details['name_client'] }}</h3>
    <h4>Se ha generado su receta con fecha y hora: </h4>
    <p> {{ $details['fecha'] }} </p>
    <b>
        <p>Detalle de la receta: </p>
    </b>
    <hr>
    <p><b>Atendido por:</b> {{ $details['veterinario'] }}</p>
    <p><b>Paciente:</b> {{ $details['paciente'] }}</p>
    <p><b>Motivo:</b> {{ $details['motivo'] }}</p>
    <p><b>Diagnostico:</b> {{ $details['diagnostico'] }}</p>
    <p><b>Tratamiento:</b> {{ $details['tratamiento'] }}</p>
    <p><b>Receta:</b> {{ $details['receta'] }}</p>


</body>

</html>