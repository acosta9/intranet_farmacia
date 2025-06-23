<div class="basket">
      <a class="dropdown-toggle" data-toggle="dropdown" href="<?php echo url_for('carrito') ?>">          
          <?php if($sf_user->isAuthenticated()) { 
              $carrito = Doctrine_Core::getTable('Carrito')->findOneBy('sf_guard_user_id', $sf_user->getGuardUser()->getId());
          } else {
              $carrito = NULL;
          }
              ?>
          
          <?php if($sf_user->isAuthenticated() && $carrito) { ?>                    
          <?php if($carrito) {
              $item=$carrito->getCount($sf_user->getGuardUser()->getId());
              } else { $item=0; }
          ?>
          <div class="basket-item-count">
              <span class="count"><?php echo $item ?></span>
              <img src="/images/icon-cart.png" alt=""/>
          </div>
          <div class="total-price-basket"> 
              <span class="lbl">Tu carrito:</span>
              <span class="total-price">
                  <span class="sign"><?php if($sf_user->getMonedaa()==1) { echo "Bs "; } else { echo "$"; }?></span><span class="value"><?php echo number_format($carrito->getSubtotal($sf_user->getGuardUser()->getId(), $sf_user->getMonedaa()), 2, ',', '.'); ?></span>
              </span>
          </div>
          <?php } else { ?>
           <div class="basket-item-count">
              <span class="count"><?php echo "0" ?></span>
              <img src="/images/icon-cart.png" alt=""/>
          </div>
          <div class="total-price-basket"> 
              <span class="lbl">Tu carrito:</span>
              <span class="total-price">
                  <span class="sign"><?php if($sf_user->getMonedaa()==1) { echo "Bs "; } else { echo "$"; }?></span><span class="value"><?php echo "0,00"; ?></span>
              </span>
          </div>
          <?php } ?>
      </a>
  </div><!-- /.basket -->