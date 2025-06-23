<?php
if($kardex->getTipo()==1) {
  echo "<span class='badge bg-success'>+".$kardex["qty"]."</span>";
} else if($kardex->getTipo()==2) {
  echo "<span class='badge bg-danger'>-".$kardex["qty"]."</span>";
}
?>