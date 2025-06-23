<?php
  $arreglo = array("A veces un ganador es simplemente un soñador que nunca se rindió.", 
  "Creo mucho en el destino y creo que si algo no sucede, fue por una razón.", 
  "Dale a cada día, la posibilidad de ser el mejor día de tu vida.", 
  "El ayer es historia, el mañana es un misterio, pero el día de hoy es un regalo. Por eso se llama presente.", 
  "El éxito no es ningún accidente. Es trabajo duro, perseverancia, aprendizaje, estudio, sacrificio y, más que nada, amor a lo que haces o lo que estás aprendiendo a hacer.", 
  "El hombre que se levanta es aún más grande que el que no ha caído.", 
  "El talento gana partidos, pero el trabajo en equipo y la inteligencia ganan campeonatos.", 
  "El trabajo duro vence al talento natural.", 
  "Es mi convicción que no hay límites para aprender.", 
  "Hay una fuerza motriz más poderosa que el vapor, la electricidad y la energía atómica: la voluntad.", 
  "He fallado más de 9000 tiros en mi carrera. He perdido más de 300 partidos. En 26 ocasiones me confiaron el tiro ganador y fallé. He fallado una y otra y otra vez en mi vida. Y por eso he tenido éxito.", 
  "He fracasado una y otra vez en mi vida y es por ello que he tenido éxito.", 
  "Nunca consideres el estudio como una obligación, sino como la oportunidad para penetrar en el bello y maravilloso mundo del saber.", 
  "Nunca digas nunca, porque los límites, como el miedo, son a menudo una ilusión.", 
  "Para aprender a triunfar, primero debes aprender a fracasar.", 
  "Persevera en tu empeño y hallarás lo que buscas, prosigue tu fin sin desviarte y alcanzarás tu empeño, combate con energía y vencerás.", 
  "Puedes tener todas las virtudes del mundo en la piel, que si no tienes ni suerte ni gente que te ayude en el camino, no te sirven de nada esos dones.", 
  "Si mantienes tu juego a un cincuenta por ciento pero la mente a un noventa por ciento, acabarás ganando. Pero si mantienes tu juego al noventa por ciento y tu mente al cincuenta por ciento, acabarás perdiendo.", 
  "Si no te esfuerzas hasta el máximo ¿Cómo sabrás cuál es tu límite?", 
  "Sigue corriendo. No dejes que tus excusas te alcancen.", 
  "Todo el mundo tiene talento, pero la habilidad requiere trabajo duro.", 
  "Una locura es hacer la misma cosa una y otra vez esperando obtener resultados diferentes. Si buscas resultados distintos, no hagas siempre lo mismo.", 
  "Una vez lloré porque no tenia zapatos, luego vi a alguien que no tenia pies y me di cuenta de lo rico que era.", 
  "Yo comía cuando había comida. Cuando salí de Costa de Marfil y comencé a ganar dinero, me di cuenta que la gente comía 3 veces por día.");  
?>

<div class="row">
  <div class="col-lg-6">
    <div class="card">
      <div class="card-body">
        <div class="alert alert-success alert-dismissible">
          <button type="button" class="close" data-dismiss="alert" aria-hidden="true">×</button>
          <h5><i class="icon fas fa-check"></i> Cita del dia!</h5>
          <?php echo $arreglo[(rand(0,23))]; ?>
        </div>
      </div>
    </div>
  </div>
</div>

<script>
  $(document).ready(function() {
    $('#loading').fadeOut( "slow", function() {});
  });
</script>