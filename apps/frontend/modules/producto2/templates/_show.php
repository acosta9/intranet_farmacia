t<!-- plugin stylesheet -->
<link rel="stylesheet" href="/css/mThumbnailScroller.css">
<!-- plugin script -->
<script src="/js/mThumbnailScroller.js"></script>
<script src="/js/expander.js"></script>


<div class="container p-t-105">
  <ol class="breadcrumb">
    <li><a href="<?php echo url_for("@homepage") ?>">Inicio</a></li>
    <li><a href="<?php echo url_for("@producto") ?>?cat=<?php echo $producto->getProductoCatId() ?>"><?php echo $producto->getProductoCat() ?></a></li>
    <li><a href="javascript:;"><?php echo $producto->getNombre() ?></a></li>
  </ol>
</div>

<div class="section sec1 prod-details">
  <div class="container">
    <div class="row">
      <div class="col-xs-12 col-md-5 p-t-30">
        <div class="tabbable booking-details-tabbable">
          <div class="tab-content" >
            <div class="tab-pane fade in active" id="tab-1">
              <div class="fotorama" data-allowfullscreen="true" data-nav="thumbs" data-width="100%" data-ratio="800/600" data-maxheight="604" data-loop="true" data-thumbwidth="100" data-thumbheight="120">
                <img src="/uploads/producto/<?php echo $producto->getUrlImagen() ?>" />
                <?php
                $results = Doctrine_Query::create()
                ->select('pd.*')
                ->from('ProductoDet pd')
                ->where('pd.producto_id = ?', $producto->getId())
                ->execute();
                foreach ($results as $result) {
                ?>
                <img src="/uploads/producto/<?php echo $result->getUrlImagen() ?>" />
                <?php } ?>
              </div>
            </div>
          </div>
        </div>
        <div class="tags">
              <p class="bold">Tags:</p>
              <?php $tags = explode(";", $producto->getTags());
              $total = count($tags);
              $i=1;
              $busqueda = "";
              foreach ($tags as $item) {
                if($total == $i) {
                  $busqueda = $busqueda.trim($item);
                } else {
                  $busqueda = $busqueda.trim($item)."|";
                }
                echo "<a href='".url_for("producto")."?tag=".trim($item)."'><span style='float:left;' class='label'>$item</span></a>";
                $i++;
              }
              ?>
        </div>
      </div>


      <div class="col-xs-12 col-md-7">
        <div class="foodfit">
          <h3 class="bold"><?php echo $producto->getNombre() ?></h3>
		      <p><strong>Marca: </strong><?php echo $producto->getProductoMarca() ?></p>
		      <p><strong>Tipo: </strong><?php echo $producto->getProductoTipo() ?></p>
		      <p><strong>Categoría: </strong><?php echo $producto->getProductoCat() ?></p><br>
		      <div class="expandable p-b-40">
            <p><?php echo $producto->getDescripcion() ?></p>
		      </div>
          <div class="form-cant" >
		        <div class="price p-b-10"><?php echo $producto->getPrecNetoT();?></div>

            <?php include_component('carrito', 'agregartres', array('producto_id' => $producto->getId())); ?>
  		      <div class="social2 right">
              <span class="text-center col-md-offset-4">Comparte:</span><br>
  		        <a href="javascript:;" id="favoritoclick" class="heart">
                <i class="fa fa-heart fa-2x" aria-hidden="true" style="padding: 0px; margin: 0px; font-size: 1.4rem;"> (<?php echo $producto->getFavorito() ?>)</i>
              </a>
              <a href="https://twitter.com/share" target="_blank" class="fa fa-twitter-square fa-2x" data-text="Excelente, Maguey Market!" data-via="MagueyMarket"></a>
              <a class="fa fa-facebook-square fa-2x" target="_blank" href="https://www.facebook.com/sharer/sharer"></a>
            </div>
          </div>
        </div>
      </div>
    </div>

	  </div>
   </div>


    <div class="section sec3">
	    <div class="container">
	    	<div class="row">
		    	<div class="col-xs-12 col-md-12">
            <div class="others-prod">
              <h5 class="bold p-t-40"><i class="fa fa-bookmark" aria-hidden="true"></i>  PRODUCTOS RELACIONADOS</h5>
              <div id="products" class="p-b-60">
                <section id="gallery-product">
                  <div id="content-2" class="content2">
                    <ul>
                      <?php
                        $results = Doctrine_Query::create()
                        ->select('p.*')
                        ->from('Producto p')
                        ->where('p.tags REGEXP ?', $busqueda)
                        ->orderBy("RAND()")
                        ->limit(14)
                        ->execute();
                        foreach ($results as $result) {
                      ?>
                      <li>
                        <div class="cont-imagen">
                        <a href="<?php echo url_for("@producto"); ?>/show?id=<?php echo $result->getId(); ?>" class="hover-img">
                          <img id="prod2" src="/uploads/producto/<?php echo $result->getUrlImagen(); ?>" />
                          <div class="hover-inner"><i class="fa fa-lg fa-plus box-icon-# hover-icon round"></i></div>
                        </a>
                      </div>
                        <a href="<?php echo url_for("@producto"); ?>/show?id=<?php echo $result->getId(); ?>">
                          <div class="bold text-center black"><p><?php echo $result->getNombre(); ?><br><?php echo $result->getPrecNetoT(); ?></p></div>
                        </a>
                      </li>
                      <?php }?>
  									</ul>
                  </div>
                </section>
              </div>
            </div>
          </div>
        </div>
      </div>
    </div>

    <div class="section four">
      <div class="container">
        <div class="row">
    		<?php
    			$results = Doctrine_Query::create()
    			->select('b.*')
    			->from('Banners b')
          ->where('b.posicion = ?', 'producto')
    			->orderBy('RAND()')
    			->limit(1)
    			->execute();
    		?>
    		<?php foreach($results as $result) { ?>
          <div class="col-xs-12 col-md-12 col-lg-12">
            <div class="banner" style="background: url('/uploads/banners/<?php echo $result->getUrlImagen(); ?>') no-repeat center center; background-size: cover; -webkit-background-size: cover; -moz-background-size: cover; -o-background-size: cover;">
              <div class="col-md-12">
                <h4 class="text-white bold" style="text-align: center; margin: 0px !important; height: 120px; display: table; width: 100%;">
                  <span style="vertical-align:middle; display: table-cell;">
                    <div class="desc-banner">"<?php echo $result->getNombre(); ?>"</div>
                  </span>
                </h4>
                <button type="button" class="btn" onclick="window.location.href='<?php echo $result->getEnlace(); ?>'" style="margin: -77px 0px 0px 0px; !important">VER MÁS</button>
              </div>
            </div>
          </div>
    		<?php } ?>
      </div>
      </div>
    </div>

<?php if($sf_user->isAuthenticated()) { ?>
  <?php
    $cont = 0;
    $results = Doctrine_Query::create()
    ->select('pf.*')
    ->from('ProductosFavoritos pf')
    ->where('pf.sf_guard_user_id = ?', $sf_user->getGuardUser()->getId())
    ->andwhere('pf.producto_id = ?', $producto->getId())
    ->andwhere('pf.tipo = ?', '1')
    ->limit(1)
    ->execute();
    foreach ($results as $result) {
      $cont++;
    }
  ?>
  <?php if($cont>=1) { ?>
    <script>
      $( document ).ready(function() {
        $("#favoritoclick").addClass("favoritoclick");
      });
      $("#favoritoclick").click(function(){
        var url = "<?php echo url_for('@producto'); ?>/favorito?change=1&id=<?php echo $producto->getId(); ?>";
        window.location.href = url;
      });
    </script>
  <?php } else {?>
    <script>
      $("#favoritoclick").click(function(){
        var url = "<?php echo url_for('@producto'); ?>/favorito?id=<?php echo $producto->getId(); ?>";
        window.location.href = url;
      });
    </script>
  <?php } ?>
<?php } else { ?>
    <script>
      $("#favoritoclick").click(function(){
        var url = "<?php echo url_for('@user'); ?>";
        window.location.href = url;
      });
    </script>
<?php } ?>


	<script>
	(function($){
			$(window).load(function(){
				$("#content-1").mThumbnailScroller({
					type:"click-90",
					theme:"buttons-out"
				});
				$("#content-2").mThumbnailScroller({
					type:"click-90",
					theme:"buttons-out"
				});

				$("#info a").click(function(e){
					e.preventDefault();
					var $this=$(this),
						el=$this.attr("rel"),
						to=$this.attr("href").split("#")[1];
					if(to==="center-white"){
						to=$("#white").position().left+($("#white").width()/2)-($(el).find(".mTSWrapper").width()/2);
					}else if(to==="yellow"){
						to=$("#yellow");
					}else if(to==="by-100"){
						to="-=100";
					}
					$(el).mThumbnailScroller("scrollTo",to);
				});

			});
		})(jQuery);

		$('div.expandable p').expander({
			slicePoint: 310, // si eliminamos por defecto es 100 caracteres
      expandPrefix: ' ', // default is '... '
      expandText: '[+ VER MAS]', // por defecto es 'read more...'
			collapseTimer: 0, // tiempo de para cerrar la expanción si desea poner 0 para no cerrar
			userCollapseText: '[^]' // por defecto es 'read less...'
		})
    !function(d,s,id){var js,fjs=d.getElementsByTagName(s)[0],p=/^http:/.test(d.location)?'http':'https';if(!d.getElementById(id)){js=d.createElement(s);js.id=id;js.src=p+'://platform.twitter.com/widgets.js';fjs.parentNode.insertBefore(js,fjs);}}(document, 'script', 'twitter-wjs');

</script>
t<!-- plugin stylesheet -->
<link rel="stylesheet" href="/css/mThumbnailScroller.css">
<!-- plugin script -->
<script src="/js/mThumbnailScroller.js"></script>
<script src="/js/expander.js"></script>


<div class="container p-t-105">
  <ol class="breadcrumb">
    <li><a href="<?php echo url_for("@homepage") ?>">Inicio</a></li>
    <li><a href="<?php echo url_for("@producto") ?>?cat=<?php echo $producto->getProductoCatId() ?>"><?php echo $producto->getProductoCat() ?></a></li>
    <li><a href="javascript:;"><?php echo $producto->getNombre() ?></a></li>
  </ol>
</div>

<div class="section sec1 prod-details">
  <div class="container">
    <div class="row">
      <div class="col-xs-12 col-md-5 p-t-30">
        <div class="tabbable booking-details-tabbable">
          <div class="tab-content" >
            <div class="tab-pane fade in active" id="tab-1">
              <div class="fotorama" data-allowfullscreen="true" data-nav="thumbs" data-width="100%" data-ratio="800/600" data-maxheight="604" data-loop="true" data-thumbwidth="100" data-thumbheight="120">
                <img src="/uploads/producto/<?php echo $producto->getUrlImagen() ?>" />
                <?php
                $results = Doctrine_Query::create()
                ->select('pd.*')
                ->from('ProductoDet pd')
                ->where('pd.producto_id = ?', $producto->getId())
                ->execute();
                foreach ($results as $result) {
                ?>
                <img src="/uploads/producto/<?php echo $result->getUrlImagen() ?>" />
                <?php } ?>
              </div>
            </div>
          </div>
        </div>
        <div class="tags">
              <p class="bold">Tags:</p>
              <?php $tags = explode(";", $producto->getTags());
              $total = count($tags);
              $i=1;
              $busqueda = "";
              foreach ($tags as $item) {
                if($total == $i) {
                  $busqueda = $busqueda.trim($item);
                } else {
                  $busqueda = $busqueda.trim($item)."|";
                }
                echo "<a href='".url_for("producto")."?tag=".trim($item)."'><span style='float:left;' class='label'>$item</span></a>";
                $i++;
              }
              ?>
        </div>
      </div>


      <div class="col-xs-12 col-md-7">
        <div class="foodfit">
          <h3 class="bold"><?php echo $producto->getNombre() ?></h3>
		      <p><strong>Marca: </strong><?php echo $producto->getProductoMarca() ?></p>
		      <p><strong>Tipo: </strong><?php echo $producto->getProductoTipo() ?></p>
		      <p><strong>Categoría: </strong><?php echo $producto->getProductoCat() ?></p><br>
		      <div class="expandable p-b-40">
            <p><?php echo $producto->getDescripcion() ?></p>
		      </div>
          <div class="form-cant" >
		        <div class="price p-b-10"><?php echo $producto->getPrecNetoT();?></div>

            <?php include_component('carrito', 'agregartres', array('producto_id' => $producto->getId())); ?>
  		      <div class="social2 right">
              <span class="text-center col-md-offset-4">Comparte:</span><br>
  		        <a href="javascript:;" id="favoritoclick" class="heart">
                <i class="fa fa-heart fa-2x" aria-hidden="true" style="padding: 0px; margin: 0px; font-size: 1.4rem;"> (<?php echo $producto->getFavorito() ?>)</i>
              </a>
              <a href="https://twitter.com/share" target="_blank" class="fa fa-twitter-square fa-2x" data-text="Excelente, Maguey Market!" data-via="MagueyMarket"></a>
              <a class="fa fa-facebook-square fa-2x" target="_blank" href="https://www.facebook.com/sharer/sharer"></a>
            </div>
          </div>
        </div>
      </div>
    </div>

	  </div>
   </div>


    <div class="section sec3">
	    <div class="container">
	    	<div class="row">
		    	<div class="col-xs-12 col-md-12">
            <div class="others-prod">
              <h5 class="bold p-t-40"><i class="fa fa-bookmark" aria-hidden="true"></i>  PRODUCTOS RELACIONADOS</h5>
              <div id="products" class="p-b-60">
                <section id="gallery-product">
                  <div id="content-2" class="content2">
                    <ul>
                      <?php
                        $results = Doctrine_Query::create()
                        ->select('p.*')
                        ->from('Producto p')
                        ->where('p.tags REGEXP ?', $busqueda)
                        ->orderBy("RAND()")
                        ->limit(14)
                        ->execute();
                        foreach ($results as $result) {
                      ?>
                      <li>
                        <div class="cont-imagen">
                        <a href="<?php echo url_for("@producto"); ?>/show?id=<?php echo $result->getId(); ?>" class="hover-img">
                          <img id="prod2" src="/uploads/producto/<?php echo $result->getUrlImagen(); ?>" />
                          <div class="hover-inner"><i class="fa fa-lg fa-plus box-icon-# hover-icon round"></i></div>
                        </a>
                      </div>
                        <a href="<?php echo url_for("@producto"); ?>/show?id=<?php echo $result->getId(); ?>">
                          <div class="bold text-center black"><p><?php echo $result->getNombre(); ?><br><?php echo $result->getPrecNetoT(); ?></p></div>
                        </a>
                      </li>
                      <?php }?>
  									</ul>
                  </div>
                </section>
              </div>
            </div>
          </div>
        </div>
      </div>
    </div>

    <div class="section four">
      <div class="container">
        <div class="row">
    		<?php
    			$results = Doctrine_Query::create()
    			->select('b.*')
    			->from('Banners b')
          ->where('b.posicion = ?', 'producto')
    			->orderBy('RAND()')
    			->limit(1)
    			->execute();
    		?>
    		<?php foreach($results as $result) { ?>
          <div class="col-xs-12 col-md-12 col-lg-12">
            <div class="banner" style="background: url('/uploads/banners/<?php echo $result->getUrlImagen(); ?>') no-repeat center center; background-size: cover; -webkit-background-size: cover; -moz-background-size: cover; -o-background-size: cover;">
              <div class="col-md-12">
                <h4 class="text-white bold" style="text-align: center; margin: 0px !important; height: 120px; display: table; width: 100%;">
                  <span style="vertical-align:middle; display: table-cell;">
                    <div class="desc-banner">"<?php echo $result->getNombre(); ?>"</div>
                  </span>
                </h4>
                <button type="button" class="btn" onclick="window.location.href='<?php echo $result->getEnlace(); ?>'" style="margin: -77px 0px 0px 0px; !important">VER MÁS</button>
              </div>
            </div>
          </div>
    		<?php } ?>
      </div>
      </div>
    </div>

<?php if($sf_user->isAuthenticated()) { ?>
  <?php
    $cont = 0;
    $results = Doctrine_Query::create()
    ->select('pf.*')
    ->from('ProductosFavoritos pf')
    ->where('pf.sf_guard_user_id = ?', $sf_user->getGuardUser()->getId())
    ->andwhere('pf.producto_id = ?', $producto->getId())
    ->andwhere('pf.tipo = ?', '1')
    ->limit(1)
    ->execute();
    foreach ($results as $result) {
      $cont++;
    }
  ?>
  <?php if($cont>=1) { ?>
    <script>
      $( document ).ready(function() {
        $("#favoritoclick").addClass("favoritoclick");
      });
      $("#favoritoclick").click(function(){
        var url = "<?php echo url_for('@producto'); ?>/favorito?change=1&id=<?php echo $producto->getId(); ?>";
        window.location.href = url;
      });
    </script>
  <?php } else {?>
    <script>
      $("#favoritoclick").click(function(){
        var url = "<?php echo url_for('@producto'); ?>/favorito?id=<?php echo $producto->getId(); ?>";
        window.location.href = url;
      });
    </script>
  <?php } ?>
<?php } else { ?>
    <script>
      $("#favoritoclick").click(function(){
        var url = "<?php echo url_for('@user'); ?>";
        window.location.href = url;
      });
    </script>
<?php } ?>


	<script>
	(function($){
			$(window).load(function(){
				$("#content-1").mThumbnailScroller({
					type:"click-90",
					theme:"buttons-out"
				});
				$("#content-2").mThumbnailScroller({
					type:"click-90",
					theme:"buttons-out"
				});

				$("#info a").click(function(e){
					e.preventDefault();
					var $this=$(this),
						el=$this.attr("rel"),
						to=$this.attr("href").split("#")[1];
					if(to==="center-white"){
						to=$("#white").position().left+($("#white").width()/2)-($(el).find(".mTSWrapper").width()/2);
					}else if(to==="yellow"){
						to=$("#yellow");
					}else if(to==="by-100"){
						to="-=100";
					}
					$(el).mThumbnailScroller("scrollTo",to);
				});

			});
		})(jQuery);

		$('div.expandable p').expander({
			slicePoint: 310, // si eliminamos por defecto es 100 caracteres
      expandPrefix: ' ', // default is '... '
      expandText: '[+ VER MAS]', // por defecto es 'read more...'
			collapseTimer: 0, // tiempo de para cerrar la expanción si desea poner 0 para no cerrar
			userCollapseText: '[^]' // por defecto es 'read less...'
		})
    !function(d,s,id){var js,fjs=d.getElementsByTagName(s)[0],p=/^http:/.test(d.location)?'http':'https';if(!d.getElementById(id)){js=d.createElement(s);js.id=id;js.src=p+'://platform.twitter.com/widgets.js';fjs.parentNode.insertBefore(js,fjs);}}(document, 'script', 'twitter-wjs');

</script>
