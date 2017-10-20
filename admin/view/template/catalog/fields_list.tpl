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


      <div class="buttons" style="float:right;">
      <a onclick="location = '<?php echo $insert; ?>'" class="markbutton button_orange nohref"><?php echo $button_insert; ?></a>
      <a onclick="$('#form').attr('action', '<?php echo $copy; ?>'); $('#form').submit();" class="markbutton button_orange nohref"><?php echo $button_copy; ?></a>
      <a onclick="$('form').submit();" class="markbutton button_orange nohref"><?php echo $button_delete; ?></a>
      </div>
     <div style="width: 100%; overflow: hidden; clear: both; height: 1px; line-height: 1px;">&nbsp;</div>





  <div class="box">
   <div class="content">
      <form action="<?php echo $delete; ?>" method="post" enctype="multipart/form-data" id="form">
        <table class="mytable">
          <thead>
            <tr>
              <td width="1" style="text-align: center;">
              <input type="checkbox" onclick="$('input[name*=\'selected\']').attr('checked', this.checked);" />
              </td>
              <td class="left">
				<?php echo $language->get('column_id'); ?>
               </td>
              <td class="left"><?php echo $column_image; ?></td>
              <td class="left"><?php echo $column_name; ?></td>

              <td class="left"><?php echo $language->get('column_type'); ?></td>
              <td class="left"><?php echo $language->get('column_description'); ?></td>
              <td class="left"><?php echo $language->get('column_order'); ?></td>
              <td class="left"><?php echo $language->get('column_must'); ?></td>

              <td class="right"><?php echo $column_action; ?></td>
            </tr>
          </thead>
          <tbody>
          <?php if ($fields) { ?>
            <?php foreach ($fields as $field) { ?>
            <tr>
              <td style="text-align: center;"><?php if ($field['selected']) { ?>
                <input type="checkbox" name="selected[]" value="<?php echo $field['field_id']; ?>" checked="checked" />
                <?php } else { ?>
                <input type="checkbox" name="selected[]" value="<?php echo $field['field_id']; ?>" />
                <?php } ?></td>

                <td style="color: #999;">
                 <?php echo $field['field_id']; ?>
                </td>



             <!-- <td class="center"><img src="<?php echo $field['field_image']; ?>" alt="<?php echo $field['field_name']; ?>" style="padding: 1px; border: 1px solid #DDDDDD;" /></td> -->
              <td class="left">
              <div style="float: left;">
              <img src="<?php echo $field['field_image']; ?>" alt="<?php echo $field['field_name']; ?>" style="padding: 1px; margin-right: 15px;border: 1px solid #EEE;" />
              </div>

              </td>
              <td class="left">
              <div style="float: left; vertical-align: center; padding-top:10px;">
               <?php foreach ($field['action'] as $action) { ?>
                 <a href="<?php echo $action['href']; ?>"  style="text-decoration: none; border-bottom: 1px solid;"><?php echo $field['field_name']; ?></a>
                <?php } ?>


              </div>


              </td>
               <td class="left"><?php echo $field['field_type']; ?></td>
               <td class="left"><?php echo strip_tags($field['field_description']); ?></td>
               <td class="left"><?php echo $field['field_order']; ?></td>
               <td class="left"><?php echo $field['field_must']; ?></td>

              <td class="right"><?php foreach ($field['action'] as $action) { ?>
                <a href="<?php echo $action['href']; ?>" class="markbuttono" style="text-decoration: none; border-bottom: 1px solid;"><?php echo $action['text']; ?></a>
                <?php } ?></td>
            </tr>
            <?php } ?>
            <?php } else { ?>
            <tr>
              <td class="center" colspan="9"><?php echo $text_no_results; ?></td>
            </tr>
            <?php } ?>
          </tbody>
        </table>
      </form>
      <div class="pagination"></div>
    </div>
  </div>
</div>

<script type="text/javascript"><!--
function filter() {
	url = 'index.php?route=catalog/record&token=<?php echo $token; ?>';

	var filter_name = $('input[name=\'filter_name\']').attr('value');

	if (filter_name) {
		url += '&filter_name=' + encodeURIComponent(filter_name);
	}

	var filter_blog = $('input[name=\'filter_blog\']').attr('value');

	if (filter_blog) {
		url += '&filter_blog=' + encodeURIComponent(filter_blog);
	}

	var filter_price = $('input[name=\'filter_price\']').attr('value');

	if (filter_price) {
		url += '&filter_price=' + encodeURIComponent(filter_price);
	}

	var filter_quantity = $('input[name=\'filter_quantity\']').attr('value');

	if (filter_quantity) {
		url += '&filter_quantity=' + encodeURIComponent(filter_quantity);
	}

	var filter_status = $('select[name=\'filter_status\']').attr('value');

	if (filter_status != '*') {
		url += '&filter_status=' + encodeURIComponent(filter_status);
	}

	location = url;
}
//--></script>
<script type="text/javascript"><!--
$('#form input').keydown(function(e) {
	if (e.keyCode == 13) {
		filter();
	}
});
//--></script>
</div>
<?php echo $footer; ?>
