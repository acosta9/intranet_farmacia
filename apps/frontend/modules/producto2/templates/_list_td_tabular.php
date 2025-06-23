<div class="col-md-3 col-xs-12">
	<div class="thumbnail">
		<a href="<?php echo url_for('producto/show?id='.$producto->getId()); ?>" class="hover-img">
			<img id="prod" src="/uploads/producto/<?php echo $producto->getUrlImagen();?>" alt="...">
			<div class="hover-inner"><i class="fa fa-lg fa-plus box-icon-# hover-icon round"></i></div>
		</a>
		<a href="<?php echo url_for('producto/show?id='.$producto->getId()); ?>">
			<div class="caption">
				<a href="<?php echo url_for('producto/show?id='.$producto->getId()); ?>"> <p class="text-center"><?php echo $producto->getNombre();?></p>
				<p class="bold text-center"><?php echo $producto->getPrecNetoT();?></p></a>
			</div>
		</a>
	</div>
</div>
