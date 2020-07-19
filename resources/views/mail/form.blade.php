
Hola! <i>{{ $demo->receiver }}</i>,
<p>Reporte desde sistema de postualciones:  {{$demo->program}}</p>
 
<p><u>Mas detalles de Reporte:</u></p>
 
<div>
<p><b>Observación:</b>&nbsp;{{ $demo->demo_one }}</p>
<p><b>Responsable:</b>&nbsp;{{ $demo->responsable }}</p>
<p><b>Id Formulario:</b>&nbsp;{{ $demo->requirement_id }}</p>
<p><b>Derivado por:</b>&nbsp;{{ $demo->derivator_name }}</p>


</div>
 

 
<div>
<p><b>Fecha de derivación:</b>&nbsp;{{ $testVarOne }}</p>

</div>
 
Saludos,
<br/>
<i>{{ $demo->sender }}</i>