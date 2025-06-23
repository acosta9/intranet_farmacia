<div class="page-title page-title-default title-size-default title-design-centered color-scheme-light" 
style="background-image: url(https://woodmartcdn-cec2.kxcdn.com/wp-content/uploads/2017/01/faqs-page-title.jpg);">
  <div class="container">
    <header class="entry-header">
      <h1 class="entry-title">PREGUNTAS FRECUENTES</h1>
      <div class="breadcrumbs" xmlns:v="http://rdf.data-vocabulary.org/#">
        <a href="<?php echo url_for("@homepage"); ?>" rel="v:url" property="v:title">Inicio</a> » 
        <span class="current">FAQs</span>
      </div>
    </header>
  </div>
</div>
<div class="container">
  <div class="row content-layout-wrapper align-items-start">
    <div class="site-content col-lg-12 col-12 col-md-12" role="main">
      <article id="post-1845" class="post-1845 page type-page status-publish hentry">
        <div class="entry-content">
          <div class="vc_row wpb_row vc_row-fluid wpb_animate_when_almost_visible wpb_fadeIn fadeIn vc_custom_1494510617612 vc_row-o-equal-height vc_row-flex wpb_start_animation animated">
            <div class="wpb_column vc_column_container vc_col-sm-12 vc_col-lg-6 vc_col-md-6 vc_col-has-fill">
              <div class="vc_column-inner vc_custom_1496938621896">
                <div class="wpb_wrapper">
                  <div id="wd-5f4516c8479a8" class="title-wrapper woodmart-title-color-default woodmart-title-style-default woodmart-title-width-100 text-left woodmart-title-size-default ">
                    <div class="liner-continer">
                      <span class="left-line"></span>
                      <h4 class="woodmart-title-container title woodmart-font-weight-">INFORMACION DE COMPRA</h4>
                      <span class="right-line"></span>
                    </div>
                  </div>
                  <div class="vc_tta-container">
                    <div class="vc_general vc_tta vc_tta-accordion vc_tta-color-white vc_tta-style-classic vc_tta-shape-square vc_tta-o-shape-group vc_tta-controls-align-left vc_tta-o-no-fill vc_tta-o-all-clickable">
                      <div class="vc_tta-panels-container">
                        <div class="vc_tta-panels">
                        <?php
                            $results = Doctrine_Query::create()
                            ->select('b.*')
                            ->from('Banners b')
                            ->where('b.posicion = ?', 'faq_left')
                            ->orderBy('b.orden')
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
            </div>
            <div class="wpb_column vc_column_container vc_col-sm-12 vc_col-lg-6 vc_col-md-6 vc_col-has-fill">
              <div class="vc_column-inner vc_custom_1496938621896">
                <div class="wpb_wrapper">
                  <div id="wd-5f4516c8479a8" class="title-wrapper woodmart-title-color-default woodmart-title-style-default woodmart-title-width-100 text-left woodmart-title-size-default ">
                    <div class="liner-continer">
                      <span class="left-line"></span>
                      <h4 class="woodmart-title-container title woodmart-font-weight-">INFORMACION EXTRA</h4>
                      <span class="right-line"></span>
                    </div>
                  </div>
                  <div class="vc_tta-container">
                    <div class="vc_general vc_tta vc_tta-accordion vc_tta-color-white vc_tta-style-classic vc_tta-shape-square vc_tta-o-shape-group vc_tta-controls-align-left vc_tta-o-no-fill vc_tta-o-all-clickable">
                      <div class="vc_tta-panels-container">
                        <div class="vc_tta-panels">
                          <?php
                            $results = Doctrine_Query::create()
                            ->select('b.*')
                            ->from('Banners b')
                            ->where('b.posicion = ?', 'faq_right')
                            ->orderBy('b.orden')
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
            </div>
          </div>
        </div>     
      </article>
    </div>
  </div>
</div>