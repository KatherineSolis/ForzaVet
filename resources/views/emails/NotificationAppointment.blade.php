<html>

<head>
    <title>Cita agendada</title>
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
   
<h3>Estimado(a) {{ $details['name'] }}</h3>
    <h4>Se ha agendado una cita para la siguiente fecha y hora: </h4>
    <p>{{ $details['fecha_cita'] }} {{ $details['hora_cita'] }}</p>
    <br>
    <b>
        <p>Cualquier duda comunicarse con MVZ.Carlos Suárez</p>
        <p>Contacto: 098465103</p>
        <p>Saludos cordiales</p>
    </b>
<br>

</div>      
</body>

</html>