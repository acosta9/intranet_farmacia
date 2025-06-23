<?php
  use_helper('I18N');
?>
<?php if ($sf_user->isAuthenticated()): ?>
  <footer class="main-footer">
    <?php echo __('<strong>Copyright &copy; %current_year% <a href="mailto:juan9acosta@gmail.com">%site_name%</a></strong> Todos los derechos reservados', array('%current_year%' => date('Y'),'%siteref%' => sfAdminDash::getProperty('siteref'), '%site_name%' => sfAdminDash::getProperty('site'))); ?>
    <div class="float-right d-none d-sm-inline-block">
      <?php echo __('<b>Version:</b> %version%', array('%version%' => sfAdminDash::getProperty('version'))) ?>
    </div>
  </footer>

  <!-- Control Sidebar -->
  <aside class="control-sidebar control-sidebar-dark">
    <!-- Control sidebar content goes here -->
  </aside>
  <!-- /.control-sidebar -->
<?php endif; ?>
