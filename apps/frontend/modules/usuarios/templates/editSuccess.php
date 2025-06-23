<section id="main" role="document">
    <div class="container">
        <div class="row">
            <section id="contents" class="content span12" role="main">
                <div class="ya-page main">
                    <div class="breadcrumbs">
                        <ul class="breadcrumb">
                            <li>
                                <a href="<?php echo url_for('@homepage') ?>">Inicio</a>
                                <span class="divider">/</span>
                            </li>
                            <li>
                                <a href="<?php echo url_for('sf_guard_user')."/".$sf_user->getGuardUser()->getId()."/show"?>">Mi cuenta</a>
                                <span class="divider">/</span>
                            </li>
                            <li class="active"><span>Cambiar contraseña</span></li>
                        </ul>
                    </div>
                    <div class="woocommerce">
                        <article class="post-260 page type-page status-publish hentry instock">
                            <header>
                                <h2 class="entry-title">Cambiar contraseña</h2>
                            </header>
                            <div class="entry-content">                                    
                                    <?php include_partial('usuarios/form', array('sf_guard_user' => $sf_guard_user, 'form' => $form, 'configuration' => $configuration, 'helper' => $helper)) ?>                                
                            </div>                                                    
                        </article>
                    </div>                
                </div>
            </section>
        </div>
    </div>
</section>
