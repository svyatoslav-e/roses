<?php echo $header; ?><?php echo $column_left; ?>
<div id="content">
  <div class="scp_grad" style="overflow: hidden;">
    <div style="float:left; margin-top: 10px;" >
    	<img src="view/image/blog-icon.png" style="height: 21px; margin-left: 10px; " >
    </div>

<div style="margin-left: 10px; float:left; margin-top: 10px;  color: #777;">
<ins style="color: #00A3D9; padding-top: 17px; text-shadow: 0 2px 1px #FFFFFF; padding-left: 3px;  font-weight: normal;  text-decoration: none; ">
<?php echo strip_tags($heading_title); ?> :: <?php  echo $theme;     ?>
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




      <div class="buttons" style="float:right;">
      <a onclick="$('#form').submit();" class="markbuttono asc_blinking nohref"><?php echo $language->get('button_adapter'); ?></a>
      <a onclick="location = '<?php echo $cancel; ?>';" class="markbuttono  nohref"><?php echo $language->get('button_cancel'); ?></a>
      </div>

      <div style="width: 100%; overflow: hidden; clear: both; height: 1px; line-height: 1px;">&nbsp;</div>


  <div class="box">
   <div class="content">

    	<form action="<?php echo $action; ?>" method="post" enctype="multipart/form-data" id="form">
          <table class="form">
            <tr>
              <td><?php echo $language->get('entry_success')."<b>".$theme."</b> .../".$file_theme; ?></td>
              <td>
               <textarea name="success_file"  rows="20" style="width: 100%;"><?php echo $success_data; ?></textarea>
              </td>
            </tr>

            <tr>
              <td><?php echo $language->get('entry_replace_breadcrumb'); ?></td>
              <td><?php if ($replace_breadcrumb) { ?>
                <input type="radio" name="replace_breadcrumb" value="1" checked="checked" />
                <?php echo $text_yes; ?>
                <input type="radio" name="replace_breadcrumb" value="0" />
                <?php echo $text_no; ?>
                <?php } else { ?>
                <input type="radio" name="replace_breadcrumb" value="1" />
                <?php echo $text_yes; ?>
                <input type="radio" name="replace_breadcrumb" value="0" checked="checked" />
                <?php echo $text_no; ?>
                <?php } ?></td>
            </tr>

            <tr>
              <td><?php echo $language->get('entry_replace_breadcrumb_name'); ?></td>
              <td><input type="text" name="replace_breadcrumb_name" value="<?php echo $replace_breadcrumb_name; ?>" size="40" /></td>
            </tr>

            <tr>
              <td><?php echo $language->get('entry_replace_main_name'); ?></td>
              <td><input type="text" name="replace_main_name" value="<?php echo $replace_main_name; ?>" size="40" /></td>
            </tr>

            <tr>
              <td><?php echo $language->get('entry_remove_tag'); ?></td>
              <td>

               <?php
              if (isset($success_tag)) {
              foreach ($success_tag as $num => $tag) {
              if (in_array($tag, $remove_tag[$theme])) {

              ?>
               <input type="checkbox" value="<?php echo $tag; ?>" name="selected_tag[]" checked="checked" >
              <?php
              print_r($tag);
              } else {
              ?>
               <input type="checkbox" value="<?php echo $tag; ?>" name="selected_tag[]">
              <?php
              print_r($tag);
              }
               ?>
              <br>
              <?php
              }
              }
               ?>

              </td>
            </tr>


            <tr>
              <td><?php echo $language->get('entry_remove_id'); ?></td>
              <td>

               <?php
              if (isset($success_id)) {
              foreach ($success_id as $num => $id) {
              if (in_array($id, $remove_id[$theme])) {

              ?>
               <input type="checkbox" value="<?php echo $id; ?>" name="selected_id[]" checked="checked" >
              <?php
              print_r($id);
              } else {
              ?>
               <input type="checkbox" value="<?php echo $id; ?>" name="selected_id[]">
              <?php
              print_r($id);
              }
               ?>
              <br>
              <?php
              }
              }
               ?>

              </td>
            </tr>

            <tr>
              <td><?php echo $language->get('entry_remove_class'); ?></td>
              <td>

               <?php
              if (isset($success_class)) {
              foreach ($success_class as $num => $class) {              	foreach ($class as $n => $classic) {
              if (in_array($classic, $remove_class[$theme])) {
              ?>
               <input type="checkbox" value="<?php echo $classic; ?>" name="selected_class[<?php echo $classic; ?>][]" checked="checked" >
              <?php
              print_r($classic);
              } else {              ?>
               <input type="checkbox" value="<?php echo $classic; ?>" name="selected_class[<?php echo $classic; ?>][]">
              <?php
              print_r($classic);
              }
               ?>
              <br>
              <?php
              }
              }
              }
               ?>

              </td>
            </tr>

            <tr>
              <td><?php if (isset($time)) echo $time; ?></td>
              <td>

              </td>
            </tr>


          </table>


   		</form>
    </div>
  </div>
</div>

<script language="javascript">
var myEditor = new Array();

function load_editor(idName, idHeight) {
	if (!myEditor[idName]) {
	    CKEDITOR.remove(idName);
		var html = $('#'+idName).html();
		var config = {
						filebrowserBrowseUrl: 'index.php?route=common/filemanager&token=<?php echo $token; ?>',
						filebrowserImageBrowseUrl: 'index.php?route=common/filemanager&token=<?php echo $token; ?>',
						filebrowserFlashBrowseUrl: 'index.php?route=common/filemanager&token=<?php echo $token; ?>',
						filebrowserUploadUrl: 'index.php?route=common/filemanager&token=<?php echo $token; ?>',
						filebrowserImageUploadUrl: 'index.php?route=common/filemanager&token=<?php echo $token; ?>',
						filebrowserFlashUploadUrl: 'index.php?route=common/filemanager&token=<?php echo $token; ?>',
						enterMode 	: CKEDITOR.ENTER_BR,
						entities 	: false,
						htmlEncodeOutput : false


					};


		myEditor[idName] = CKEDITOR.replace(idName, config, html );

		CKEDITOR.remove(myEditor[idName]);
	} 	else {
		var currentVal = '';
		$('#'+idName).html(currentVal + myEditor[idName].getData());
		// Destroy editor
		myEditor[idName].destroy();
		myEditor[idName] = null;
	}
}
</script>
</div>
<?php echo $footer; ?>