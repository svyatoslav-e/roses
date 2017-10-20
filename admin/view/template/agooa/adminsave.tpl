   <?php

   if (count($settings_install) > 0) {
   ?>
   <div class="asc_marginleft5px">
   <?php
   if (isset($settings_install['ascp_install_1']) && $settings_install['ascp_install_1']) {
    ?>
    <img src="view/image/ascp_install_true.gif" style="height: 10px;  " >
   <?php
   } else {
   ?>
      <img src="view/image/ascp_install_false.gif" style="height: 10px;  " >

   <?php
    }

   if (isset($settings_install['ascp_install_2']) && $settings_install['ascp_install_2']) {
    ?>
    <img src="view/image/ascp_install_true.gif" style="height: 10px;  " >
   <?php
   } else {
   ?>
      <img src="view/image/ascp_install_false.gif" style="height: 10px;  " >

   <?php
    }


   if (isset($settings_install['ascp_install_3']) && $settings_install['ascp_install_3']) {
    ?>
    <img src="view/image/ascp_install_true.gif" style="height: 10px;  " >
   <?php
   } else {
   ?>
      <img src="view/image/ascp_install_false.gif" style="height: 10px;  " >

   <?php
    }


   if (isset($settings_install['ascp_install_4']) && $settings_install['ascp_install_4']) {
    ?>
    <img src="view/image/ascp_install_true.gif" style="height: 10px;  " >
   <?php
   } else {
   ?>
      <img src="view/image/ascp_install_false.gif" style="height: 10px;  " >

   <?php
    }
   ?>
    </div>
   <?php
   }
   ?>