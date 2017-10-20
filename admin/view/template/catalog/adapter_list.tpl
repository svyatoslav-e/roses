<?php echo $header; ?><?php echo $column_left; ?>
<div id="content">
  <div class="scp_grad" style="overflow: hidden;">
    <div style="float:left; margin-top: 10px;" >
    	<img src="view/image/blog-icon.png" style="height: 21px; margin-left: 10px; " >
    </div>

<div style="margin-left: 10px; float:left; margin-top: 10px;  color: #777;">
<ins style="color: #00A3D9; padding-top: 17px; text-shadow: 0 2px 1px #FFFFFF; padding-left: 3px;  font-weight: normal;  text-decoration: none; ">
<?php echo strip_tags($heading_title); ?>
</ins> ver.: <?php echo $blog_version; ?>
</div>

    <div class="scp_grad_green" style=" height: 40px; float:right; ">
      <div style="color: #555;margin-top: 2px; line-height: 18px; margin-left: 9px; margin-right: 9px; overflow: hidden;"><?php echo $language->get('heading_dev'); ?></div>
    </div>

</div>

  <div class="page-header">
    <div class="container-fluid">

<script type="text/javascript" src="view/javascript/ckeditor/ckeditor.js"></script>


<div id="content1" style="border: none;">

<div style="clear: both; line-height: 1px; font-size: 1px;"></div>


<?php if ($error_warning) { ?>
    <div class="alert alert-danger warning"><i class="fa fa-exclamation-circle"></i> <?php echo $error_warning; ?>
      <button type="button" class="close" data-dismiss="alert">&times;</button>
    </div>
<?php } ?>

<?php if ($success) { ?>
    <div class="alert alert-success success"><i class="fa fa-check-circle"></i> <?php echo $success; ?>
      <button type="button" class="close" data-dismiss="alert">&times;</button>
    </div>
<?php } ?>


<div class="box1">

<div class="content">

<?php echo $agoo_menu; ?>



     <div style="width: 100%; overflow: hidden; clear: both; height: 1px; line-height: 1px;">&nbsp;</div>


  <div class="box">
   <div class="content">
      <form action="<?php echo $delete; ?>" method="post" enctype="multipart/form-data" id="form">
        <table class="mytable">
          <thead>
            <tr>
              <td class="left"><?php echo $column_image; ?></td>
              <td class="left"><?php echo $column_name; ?></td>
              <td class="right"><?php echo $column_action; ?></td>
            </tr>
          </thead>
          <tbody>
          <?php if ($adapter) { ?>
            <?php foreach ($adapter as $adapter) { ?>


            <tr class="<?php if ($config_theme == $adapter['adapter_name']) { echo 'asc_active-theme'; } ?>">

			 <td class="left">
              <div style="float: left;">
              <img src="<?php echo $adapter['adapter_image']; ?>" alt="<?php echo $adapter['adapter_name']; ?>" style="padding: 1px; margin-right: 15px;border: 1px solid #EEE;" />
              </div>
             </td>

              <td class="left">
              <div style="float: left; vertical-align: center; padding-top:10px;">
               <?php foreach ($adapter['action'] as $action) { $action = end($adapter['action']); ?>
                 <a href="<?php echo $action['href']; ?>"  class="as_theme_link" style="text-decoration: none; border-bottom: 1px solid;"><?php echo $adapter['adapter_name']; ?></a><br>
                 <span class="asc_current-theme"><?php if ($config_theme == $adapter['adapter_name']) { echo $language->get('theme_status'); } ?></span>
                <?php
                break;
                } ?>
              </div>
             </td>

              <td class="right">
              <?php foreach ($adapter['action'] as $action) { ?>
               <div style="margin-bottom: 10px;">
                <a href="<?php echo $action['href']; ?>" class="<?php if($action['text']!='.') { echo 'markbuttono ';  if ($config_theme == $adapter['adapter_name']) { echo 'asc_blinking '; }  } ?>" style="text-decoration: none; <?php if($action['text']=='.') echo 'float: right;'; ?>"><?php echo $action['text']; ?></a>
               </div>
              <?php } ?>
              </td>

            </tr>
            <?php } ?>
            <?php } else { ?>
            <tr>
              <td class="center" colspan="8"><?php echo $text_no_results; ?></td>
            </tr>
            <?php } ?>
          </tbody>
        </table>
      </form>
      <div class="pagination"></div>
    </div>
  </div>
</div>
</div>
<?php echo $footer; ?>
