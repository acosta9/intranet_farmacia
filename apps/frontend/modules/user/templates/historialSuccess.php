<?php use_helper('Date') ?>
<div class="container p-t-105">
    <h1 class="page-title">Historial de compras</h1>
</div>

<div class="container">
  <div class="row">
    <?php if ($sf_user->hasFlash('notice')): ?>
      <div class="col-md-12">
        <div class="alert alert-success m-t-10 m-b-20">
          <a href="#" class="close" data-dismiss="alert" aria-label="close">&times;</a>
          <?php echo $sf_user->getFlash('notice') ?>
        </div>
      </div>
    <?php endif; ?>

    <div class="col-md-3">
      <aside class="user-profile-sidebar">
        <div class="user-profile-avatar text-center">
          <?php if ($sf_guard_user->getUrlImagen())  { ?>
            <img style="max-width: 120px; height: 120px;" src="/uploads/sf_guard_user/<?php echo $sf_guard_user->getUrlImagen(); ?>" alt="<?php echo $sf_guard_user->getFirstName(); ?>">
          <?php } else { ?>
            <img style="border-radius: 50%; max-width: 120px; height: 120px;" src="/images/user.png" alt="sin avatar">
          <?php } ?>
          <h5><?php echo $sf_guard_user->getFirstName(); ?></h5>
          <p>Miembro desde <?php echo format_datetime($sf_guard_user->getCreatedAt(), 'D', 'es_ES'); ?></p>
        </div>
        <ul class="list user-profile-nav">
          <li><a href="<?php echo url_for("user")?>/micuenta"><i class="fa fa-user"></i>Editar Perfil</a></li>
          <li><a href="<?php echo url_for("user")?>/favoritos"><i class="fa fa-heart"></i>Favoritos</a></li>
          <li><a href="<?php echo url_for("user")?>/historial"><i class="fa fa-clock-o"></i>Compras</a></li>
        </ul>
      </aside>
    </div>
    <div class="col-md-9 tabla-historial">
      <table class="table table-bordered table-striped table-booking-history">
        <thead>
          <tr>
						<th width="20%"><b>Descripción</b></th>
						<th width="30%"><b>Dirección de envío</th>
						<th width="10%"><b>Fecha de compra</b></th>
						<th width="25%"><b>Fecha de envío</b></th>
						<th width="15%"><b>Monto</b></th>
					</tr>
				</thead>
				<tbody>
					<?php foreach ($results as $result) {
						$date = new DateTime($result->getCreatedAt());
	          $fechaorder=$date->format("l jS \of F Y h:i:s A");
	          $fecha=$date->format("Y-m-d");

	          $estimate1 = date('d/m/Y',strtotime('+5 days', strtotime($fecha)));
	          $estimate2 = date('d/m/Y',strtotime('+10 days', strtotime($fecha)));
						?>
						<tr>
							<td class="booking-history-title"><?php echo $result->getTitulo() ?></td>
							<td><?php echo $result->getDirEnvioEstado().", ".$result->getDirEnvioCiudad().", ".$result->getDirEnvioDelegacion().", ".$result->getDirEnvioColonia().", ".$result->getDirEnvioDireccion() ?></td>
							<td><?php echo $date->format("d/m/Y"); ?></td>
							<td><?php echo $estimate1." <i class='fa fa-long-arrow-right'></i> ".$estimate2?></td>
							<td><?php echo "$ ".($result->getTotal()+$result->getCostoenvio());?></td>
						</tr>
					<?php } ?>
				</tbody>
			</table>
    </div>
  </div>
</div>
