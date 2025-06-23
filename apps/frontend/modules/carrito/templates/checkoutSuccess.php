<div class="row">
    <div class="large-12 columns">
        <h2>Checkout</h2>
    </div>
</div>

<div class="row">
    <div class="large-6 medium-6 small-12 columns">
        <div class="col-2 address">
            <div class="row">
                <div class="large-12 columns">
                    <header class="title">
                        <h3>Direccion de facturacion</h3>
                        <a href="<?php echo url_for('sf_guard_billing_address')."/new"?>" class="edit">Editar</a>
                    </header>
                </div>
            </div>
            <div class="row">
                <div class="large-12 columns">
                    <address>
                        <?php
                            $billingAddr=Doctrine::getTable('SfGuardBillingAddress')->findOneBy('sf_guard_user_id',$sf_user->getGuardUser()->getId());
                            if(empty($billingAddr)) {
                                echo "Usted no ha configurado este tipo de dirección aún.";
                            } else {
                                echo "<p>".$billingAddr->getCedula().$billingAddr->getRif()."</p>";
                                echo "<p>".$billingAddr->getFirstName()." ".$billingAddr->getLastName()."</p>";                                                    
                                echo "<p>".$billingAddr->getAddress()."</p>";
                                echo "<p>".$billingAddr->getCity().", ".$billingAddr->getState()." ".$billingAddr->getPostCode()."</p>";                                                    
                                echo "<p>".$billingAddr->getPhone()."</p>";
                            }
                        ?>                                            
                    </address>
                </div>
            </div>
        </div>
    </div>
    <div class="large-6 medium-6 small-12 columns">                                    
        <div class="col-2 address">
            <div class="row">
                <div class="large-12 columns">
                    <header class="title">
                        <h3>Direccion de envio</h3>
                        <a href="<?php echo url_for('sf_guard_shipping_address')."/new"?>" class="edit">Editar</a>
                    </header>
                </div>
            </div>
            <div class="row">
                <div class="large-12 columns">
                    <address>
                        <?php
                            $shippingAddr=Doctrine::getTable('SfGuardShippingAddress')->findOneBy('sf_guard_user_id',$sf_user->getGuardUser()->getId());
                            if(empty($shippingAddr)) {
                                echo "You have not set up this type of address yet.";
                            } else {
                                echo "<p>".$shippingAddr->getCedula().$shippingAddr->getRif()."</p>";
                                echo "<p>".$shippingAddr->getFirstName()." ".$shippingAddr->getLastName()."</p>";                                                    
                                echo "<p>".$shippingAddr->getAddress()."</p>";
                                echo "<p>".$shippingAddr->getCity().", ".$shippingAddr->getState()." ".$shippingAddr->getPostCode()."</p>";                                                    
                                echo "<p>".$shippingAddr->getPhone()."</p>";
                            }
                        ?>
                    </address>
                </div>
            </div>
        </div>
    </div>
</div>
                            
 <div class="row">
     <div class="large-12 columns">
         <h3 id="order_review_heading"><br/>Tu orden</h3>
     </div>
 </div>

 <div class="row">
     <div class="large-12 columns">
        <div id="order_review" style="position: relative; zoom: 1;">
            <table class="shop_table">
                <thead>
                    <tr>
                        <th class="product-name">Producto</th>
                        <th class="product-total">Total</th>
                    </tr>
                </thead>
                <tfoot>
                    <tr class="total">
                        <th><strong>Total</strong></th>
                        <td>
                            <strong><span class="amount"><?php 
                              if($sf_user->getMonedaa()==1)
                                  echo "Bs ";
                              else 
                                  echo "$";
                              echo number_format($carr->getSubtotal($sf_user->getGuardUser()->getId(), $sf_user->getMonedaa()), 2, ',', '.'); ?></span></strong>
                        </td>
                    </tr>
                </tfoot>
                <tbody>
                    <?php 
                    $mp = new MP ("7733640549555213", "lTrbaZ6IiPxBA4sw4CqdryO5NrDel0HC");
                    $titulo=""; $preciot=0; $titulo_cant=0; $i=0;
                    ?>
                    <?php foreach($carritos as $carrito) { 
                        $producto=Doctrine::getTable('Producto')->findOneBy('id',$carrito->getProductoId());
                        ?>                                            
                        <tr class="checkout_table_item">
                            <td class="product-name"><?php echo $producto->getNombre(); ?> <strong class="product-quantity"><?php list($mm, $pp)=  explode(" ",$producto->getPrecNetoT($sf_user->getMonedaa())); echo "<br/>(".$mm." ".number_format($pp, 2, ',', '.');  ?> × <?php echo $carrito->getCantidad()." )"; ?></strong></td>
                            <td class="product-total"><span class="amount"><?php echo $mm." ".number_format($carrito->getCantidad()*$pp, 2, ',', '.'); ?></span></td>
                        </tr>	
                        <?php 
                            $preciot+=$carrito->getCantidad()*$pp;
                            if($i==0) {
                                $titulo=$producto->getNombre();
                            }                        
                            $i++; $titulo_cant++;                      
                        }
                        
                        $titulo2="";
                        if($titulo_cant=="1") {
                            $titulo2=$titulo;
                            $titulo=$titulo2.'".';            
                        } else {
                            $titulo_cant=$titulo_cant-1;                            
                            $titulo=$titulo.'..." y '.$titulo_cant.' articulo mas.';

                        } 
                        
                        $preference_data = array(
                            "items" => array(
                                array(                                    
                                    "title" => $titulo,
                                    "currency_id" => "VEF",
                                    "picture_url" =>"https://www.mercadopago.com/org-img/MP3/home/logomp3.gif",                                    
                                    "quantity" => 1,
                                    "unit_price" => (float)$preciot
                                )
                            ),
                            "back_urls" => array(
                                    "success" => "http://intersellgroup.com/web/carrito/success",
                                    "failure" => "http://intersellgroup.com/web/carrito/failure",
                                    "pending" => "http://intersellgroup.com/web/carrito/pending"
                            ),                            
                            "notification_url" => "http://intersellgroup.com/web/carrito/ipn",	
                            );

                        
                        ?>
                        <?php                        
                     //   var_dump($preference_data); die();
                        $preference = $mp->create_preference($preference_data);
                   //     print_r ($preference);
                   //     die();
                        ?>
                </tbody>
            </table>
            <form action="<?php echo url_for('carrito/placeorder')?>" method="get">
                <div id="payment">
                    <ul class="payment_methods methods">   
                        <?php if($sf_user->getMonedaa() == 2 ) { ?>
                        <li>
                            <input type="radio" name="pago" class="input-radio" value="deposito" checked/>
                            <label for="payment_method_cheque">Pago por deposito o transferencia </label>
                            <div class="payment_box payment_method_cheque">
                                La informacion de las cuentas disponibles para realizar los depositos se enviaran al correo especificado previamente una vez le de click al boton COMPRAR
                            </div>						
                        </li>
                        <?php } else { ?>
                        
                        <?php } ?>
                    </ul>
                    <br/>
                    <div class="form-row place-order">
                        <?php if($sf_user->getMonedaa() == 2 ) { ?>
                            <input style="float: right; margin-right: 10px; border-radius: 4px" type="submit" class="button success" value="Comprar">                        
                        <?php } else { ?>
                            <a href="<?php echo $preference["response"]["sandbox_init_point"]; ?>" name="MP-Checkout" class="button success mercadopago">PAGAR CON MERCADOPAGO</a>
                            <script type="text/javascript" src="http://mp-tools.mlstatic.com/buttons/render.js"></script>                            
                        <?php } ?>                                           
                    </div>    
                    <br/><br/><br/><br/>
                </div>
            </form>
            
        </div>
     </div>
 </div>