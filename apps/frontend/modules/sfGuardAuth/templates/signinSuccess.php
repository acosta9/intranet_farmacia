<div class="main-page-wrapper">
  <div class="page-title page-title-default title-size-default title-design-centered color-scheme-light" style="">
    <div class="container">
      <header class="entry-header">
        <h1 class="entry-title">Iniciar Sesión</h1>
        <div class="breadcrumbs" xmlns:v="http://rdf.data-vocabulary.org/#">
          <a href="<?php echo url_for("@homepage"); ?>" rel="v:url" property="v:title">Inicio</a> » 
          <span class="current">Iniciar Sesión</span>
        </div>
      </header>
    </div>
  </div>
  <div class="container">
    <div class="row content-layout-wrapper align-items-start">
      <div class="site-content col-lg-12 col-12 col-md-12" role="main">
        <article id="post-15" class="post-15 page type-page status-publish hentry">
          <h2><strong>El nombre de usuario o contraseña no son válidos.</strong></h2>
          <?php include_component('sfGuardAuth', 'signin'); ?>
        </article>
      </div>
    </div>
  </div>
</div>