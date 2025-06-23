<div class="row">
    <div class="large-12 columns usuario">
        <h2 class="bordered">Mi cuenta</h2>
        <p>Hola, <strong><?php echo $sf_user->getGuardUser()->getUsername(); ?></strong>. Desde aca podrá ver sus pedidos recientes, solicitudes de presupuestos, administrar sus direcciones de envío y <a href="<?php echo url_for('sf_guard_user_password')."/".$sf_user->getGuardUser()->getId()."/edit"?>">cambiar contraseña</a>.</p>
        <h3>Puedes ver <a href ="<?php echo url_for("orders")?>">Tus ordenes aqui</a></h3>        
    </div>    
</div>

<div class="row">
    <div class="large-6 medium-6 small-12 columns">        
        <div class="direccion">
            <div class="title-usuario">
                <h3>Detalles</h3>
                <a href="<?php echo url_for('usuarios_usuarios_det')."/new"?>" class="edit">Editar</a>
            </div>
            <address>
                <?php
                    $usuario=Doctrine::getTable('Usuarios')->findOneBy('sf_guard_user_id',$sf_user->getGuardUser()->getId());
                    if(empty($usuario)) {
                        echo "Usted no ha llenado esta informacion.";
                    } else {
                        echo "<p>".$usuario->getCedula()."</p>";                                                    
                        echo "<p>".$usuario->getFirstName()." ".$usuario->getLastName()."</p>";                                                    
                        echo "<p>".$usuario->getDireccion()."</p>";                                                    
                        echo "<p>".$usuario->getTelf()."</p>";
                        echo "<p>".$usuario->getCelular()."</p>";
                    }
                ?>                                            
            </address>
        </div>
    </div>
    <div class="large-6 medium-6 small-12 columns">        
        <div class="direccion">
            <div class="title-usuario">
                <h3>Datos para realizar pagos</h3>                                            
            </div>
            <address>
                <?php                                                                                                                                              
                    echo "<p>banco banplus, cta. corritente 0174 0138 66 1384120836</p>";                                                    
                    echo "<p>banco banesco, cta. corritente  0134 1070 45 0001005131</p>";                                                    
                    echo "<p>IntersellGroup C.A</p>";
                    echo "<p>Rif: J-400227506</p>";                                                
                ?>                                            
            </address>
        </div>
    </div>
</div>

<div class="row" style="margin-top: 2.5rem;">
    <div class="large-6 medium-6 small-12 columns">  
        <div class="direccion">
            <div class="title-usuario">
                <h3>Direccion de facturación</h3>
                <a href="<?php echo url_for('sf_guard_billing_address')."/new"?>" class="edit">Editar</a>
            </div>
            <address>
                <?php
                    $billingAddr=Doctrine::getTable('SfGuardBillingAddress')->findOneBy('sf_guard_user_id',$sf_user->getGuardUser()->getId());
                    if(empty($billingAddr)) {
                        echo "Usted no ha establecido este tipo de dirección aún.";
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
    <div class="large-6 medium-6 small-12 columns">        
        <div class="direccion">
            <div class="title-usuario">
                <h3>Direccion de envio</h3>
                <a href="<?php echo url_for('sf_guard_shipping_address')."/new"?>" class="edit">Editar</a>
            </div>
            <address>
                <?php
                    $shippingAddr=Doctrine::getTable('SfGuardShippingAddress')->findOneBy('sf_guard_user_id',$sf_user->getGuardUser()->getId());
                    if(empty($shippingAddr)) {
                        echo "Usted no ha establecido este tipo de dirección aún.";
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