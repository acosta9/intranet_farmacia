<div class="container">
   <div class="row content-layout-wrapper align-items-start">
      <div class="site-content col-lg-12 col-12 col-md-12" role="main">
         <article id="post-1618" class="post-1618 page type-page status-publish hentry">
            <div class="entry-content">
              <div data-vc-full-width="true" data-vc-full-width-init="true" data-vc-stretch-content="true" class="vc_row wpb_row vc_row-fluid vc_custom_1496927007057 vc_row-no-padding" style="position: relative; left: -341.5px; box-sizing: border-box; width: 1905px;">
              <?php
								$results = Doctrine_Query::create()
								  ->select('b.*')
									->from('Banners b')
									->where('b.posicion = ?', 'map_contactanos')
									->orderBy('RAND()')
									->limit(1)
									->execute();
								?>
                <?php foreach($results as $result) { ?>
                  <?php echo $result->getDescripcion(); ?>">
								<?php } ?>
              </div>
              <div class="vc_row-full-width vc_clearfix"></div>
              <div class="vc_row wpb_row vc_row-fluid vc_custom_1496926452255 vc_row-o-equal-height vc_row-flex">
                <div class="wpb_column vc_column_container vc_col-sm-12 vc_col-lg-6 vc_col-md-6 vc_col-has-fill">
                  <div class="vc_column-inner vc_custom_1496927710186">
                    <div class="wpb_wrapper">
                      <div id="wd-5f4428facf2fc" class="title-wrapper woodmart-title-color-default woodmart-title-style-default woodmart-title-width-100 text-left woodmart-title-size-default ">
                        <div class="title-subtitle font-default subtitle-style-default woodmart-font-weight-">MAS INFORMACION</div>
                          <div class="liner-continer">
                             <span class="left-line"></span>
                                 <h4 class="woodmart-title-container title woodmart-font-weight-">PREGUNTAS FRECUENTES</h4>
                                 <span class="right-line"></span>
                              </div>
                           </div>
                           <div class="vc_tta-container" data-vc-action="collapseAll">
                              <div class="vc_general vc_tta vc_tta-accordion vc_tta-color-white vc_tta-style-classic vc_tta-shape-square vc_tta-o-shape-group vc_tta-controls-align-left vc_tta-o-no-fill vc_tta-o-all-clickable">
                                <div class="vc_tta-panels">
                                  <?php
                                    $results = Doctrine_Query::create()
                                    ->select('b.*')
                                    ->from('Banners b')
                                    ->where('b.posicion LIKE "faq%"')
                                    ->orderBy('b.orden')
                                    ->limit(10)
                                    ->execute();
                                  ?>
                                  <?php foreach($results as $result) { ?>
                                    <div class="vc_tta-panel" data-vc-content=".vc_tta-panel-body">
                                      <div class="vc_tta-panel-heading">
                                        <h4 class="vc_tta-panel-title vc_tta-controls-icon-position-right" style="padding-top: 1rem;">>
                                          <a href="#" data-vc-accordion="" data-vc-container=".vc_tta-container">
                                            <span class="vc_tta-title-text"><?php echo $result->getNombre(); ?></span>
                                            <i class="vc_tta-controls-icon vc_tta-controls-icon-chevron"></i>
                                          </a>
                                        </h4>
                                      </div>
                                      <div class="vc_tta-panel-body" style="">
                                        <div class="wpb_text_column wpb_content_element">
                                          <div class="wpb_wrapper">
                                            <p><?php echo $result->getDescripcion(); ?></p>
                                          </div>
                                        </div>
                                      </div>
                                    </div>
                                  <?php } ?>
                                </div>
                              </div>
                           </div>
                        </div>
                     </div>
                  </div>
                  <div class="wpb_column vc_column_container vc_col-sm-12 vc_col-lg-6 vc_col-md-6">
                    <div class="vc_column-inner vc_custom_1496927688909" style="padding-top: 35px;">
                      <div class="wpb_wrapper">
                        <div id="wd-5f4428fad0aed" class="title-wrapper woodmart-title-color-default woodmart-title-style-default woodmart-title-width-100 text-left woodmart-title-size-default ">
                          <div class="title-subtitle font-default subtitle-style-default woodmart-font-weight-">INFORMACION</div>
                            <div class="liner-continer">
                              <span class="left-line"></span>
                              <h4 class="woodmart-title-container title woodmart-font-weight-">CONTACTANOS SI TIENES ALGUNA PREGUNTA</h4>
                              <span class="right-line"></span>
                            </div>
                          </div>
                          <div role="form" class="wpcf7" id="wpcf7-f1738-p1618-o1" lang="en-US" dir="ltr">
                              <div class="screen-reader-response" role="alert" aria-live="polite"></div>
                              <?php echo form_tag_for($form, '@contactenos') ?> 
                              <?php echo $form->renderHiddenFields(false) ?>
                              <?php if ($form->hasGlobalErrors()): ?>
                                <?php echo $form->renderGlobalErrors() ?>
                              <?php endif; ?>
                                <div class="row">
                                  <div class="col-md-12" style="margin-bottom:20px;">
                                    <label class="control-label">Nombre *</label>
                                    <?php echo $form['nombre']->render(array("required" => "required")) ?>
                                    <?php echo $form['nombre']->renderError() ?>
                                  </div>
                                </div>
                                <div class="row">
                                  <div class="col-md-12" style="margin-bottom:20px;">
                                    <label class="control-label">Email *</label>
                                    <?php echo $form['email']->render(array("type" => "email", "required" => "required")) ?>
                                    <?php echo $form['email']->renderError() ?>
                                  </div>
                                </div>
                                <div class="row">
                                  <div class="col-md-12" style="margin-bottom:20px;">
                                    <label class="control-label">Mensaje *</label>
                                    <?php echo $form['mensaje']->render(array("required" => "required")) ?>
                                    <?php echo $form['mensaje']->renderError() ?>
                                  </div>
                                </div>
                                <input type="submit" class="wpcf7-form-control wpcf7-submit btn-color-black" value="ENVIAR"/>
                              </form>
                           </div>
                        </div>
                     </div>
                  </div>
               </div>
            </div>
         </article>
      </div>
   </div>
</div>

<?php if($sf_params->get('success')=="1"): ?>
<script>
  alert("mensaje enviado con exito");
</script>
<?php endif; ?>