<html>

<head>
    <title>Receta</title>
</head>

<style>
* {
  box-sizing: border-box;
}

/* Create two equal columns that floats next to each other */
.column {
  float: left;
  width: 23%;
  padding: 10px;
  height: 150px; /* Should be removed. Only for demonstration */
}

/* Clear floats after the columns */
.row:after {
  content: "";
  display: table;
  clear: both;
}
.css-class{
    
    width:150px;
}
</style>

<body>
<div style="padding:20px;border:1px solid #cccc;">
<div class="row" style="border:1px solid #ccc;">
  <div class="column" style="border:1px solid #ccc;">
    
<img src="https://vivepetresort.com/wp-content/uploads/2018/09/clinicaveterinaria-icono.png" class="css-class" alt="alt text">
  </div>
  <div class="column" style="background:#50a7b2;width:77%;">
      
      <br>
  <h2 style="color:#fff;font-size:25px;">Veterinaria</h2>
<span style="color:#fff;font-size:20px;">ForzaVet</span> 
  </div>
</div>
<br>

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
    </div>

</body>

</html>