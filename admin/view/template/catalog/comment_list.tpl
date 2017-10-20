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

      <div class="buttons" style="float:right; ">
      <a onclick="location = '<?php echo $insert; ?>'" class="mbutton button_orange nohref"><span class="sc_plus sc_round_green">+</span><?php echo $button_insert; ?></a>
      <a onclick="$('form').submit();" class="mbuttonr nohref"><span class="sc_delete sc_round_red">X</span><?php echo $button_delete; ?></a>
      </div>
     <div style="width: 100%; overflow: hidden; clear: both; height: 1px; line-height: 1px;">&nbsp;</div>



  <div class="box">
   <div class="content">
      <form action="<?php echo $delete; ?>" method="post" enctype="multipart/form-data" id="form">
       <input type="hidden" name="action" value="<?php echo $mark_name; ?>">
               <div>
                <a  onclick="$('.comment_text').toggle(); return false;" class="nohref">
                <?php echo $language->get('entry_comment_text'); ?>
                </a>
                </div>

        <table class="mytable">
          <thead>
            <tr>
              <td width="1" style="text-align: center;"><input type="checkbox" onclick="$('input[name*=\'selected\']').prop('checked', this.checked);" /></td>

              <td class="left" >
				<?php echo $column_comment_id; ?>
               </td>

              <td class="left" >
				<?php echo $column_comment_type; ?>
               </td>


              <td class="left"><?php if ($sort == 'pd.name') { ?>
                <a href="<?php echo $sort_record; ?>" class="<?php echo strtolower($order); ?>"><?php echo $column_record; ?></a>
                <?php } else { ?>
                <a href="<?php echo $sort_record; ?>"><?php echo $column_record; ?></a>
                <?php } ?>
                </td>




              <td class="left"><?php if ($sort == 'r.author') { ?>
                <a href="<?php echo $sort_author; ?>" class="<?php echo strtolower($order); ?>"><?php echo $column_author; ?></a>
                <?php } else { ?>
                <a href="<?php echo $sort_author; ?>"><?php echo $column_author; ?></a>
                <?php } ?></td>
              <td class="right"><?php if ($sort == 'r.rating') { ?>
                <a href="<?php echo $sort_rating; ?>" class="<?php echo strtolower($order); ?>"><?php echo $column_rating; ?></a>
                <?php } else { ?>
                <a href="<?php echo $sort_rating; ?>"><?php echo $column_rating; ?></a>
                <?php } ?></td>

                 <td class="left">
                  <?php echo $language->get('column_karma'); ?>
                 </td>


              <td class="left"><?php if ($sort == 'r.status') { ?>
                <a href="<?php echo $sort_status; ?>" class="<?php echo strtolower($order); ?>"><?php echo $column_status; ?></a>
                <?php } else { ?>
                <a href="<?php echo $sort_status; ?>"><?php echo $column_status; ?></a>
                <?php } ?></td>
              <td class="left"><?php if ($sort == 'r.date_added') { ?>
                <a href="<?php echo $sort_date_added; ?>" class="<?php echo strtolower($order); ?>"><?php echo $column_date_added; ?></a>
                <?php } else { ?>
                <a href="<?php echo $sort_date_added; ?>"><?php echo $column_date_added; ?></a>
                <?php } ?></td>

              <td class="left" >
				<?php echo $column_language; ?>
               </td>


              <td class="right"><?php echo $column_action; ?></td>
            </tr>
          </thead>
          <tbody>

            <tr class="filter">
              <td></td>
              <td></td>
              <td></td>
              <td><input type="text" name="filter_name" value="<?php echo $filter_name; ?>" /></td>
              <td></td>
              <td></td>
              <td></td>
              <td></td>
              <td></td>
               <td></td>
             <td align="right"><a onclick="filter();" class="markbutton button_blue nohref"><?php echo $button_filter; ?></a></td>
            </tr>


            <?php if ($comments) { ?>
            <?php foreach ($comments as $comment) { ?>
            <tr>
              <td style="text-align: center;"><?php if ($comment['selected']) { ?>
                <input type="checkbox" name="selected[]" value="<?php echo $comment['comment_id']; ?>" checked="checked" />
                <?php } else { ?>
                <input type="checkbox" name="selected[]" value="<?php echo $comment['comment_id']; ?>" />
                <?php } ?></td>
              <td class="left" style="color: #999;"><?php echo $comment['comment_id']; ?></td>
              <td class="left" style="color: #999;"><?php echo $comment['type']; ?></td>
              <td class="left"><a class="nohref" onclick="$('#comment_text_<?php echo $comment['comment_id']; ?>').toggle(); return false;"><?php echo $comment['name']; ?></a>
              <a target="_blank" href="<?php echo $comment['href'].$comment['commentlink']; ?>">#</a>


              <div id="comment_text_<?php echo $comment['comment_id']; ?>" style="display: none;" class="comment_text">
              <?php echo $comment['text']; ?>
              </div>

              </td>

              <td class="left"><?php echo $comment['author']; ?></td>
              <td class="right"><?php echo $comment['rating']; ?></td>
              <td class="right"><?php
             foreach ($comment['karma_all'] as $num => $karma_all_val) { ?>


            <input type="text" name="karma_delta" value="<?php if (isset($karma_all_val['rate_delta'])) { echo (int)$karma_all_val['rate_delta']; } ?>" disabled="disabled" size="2" style="border: 1px solid <?php if (isset($karma_all_val['rate_delta']) && $karma_all_val['rate_delta']>0) { echo 'green'; } ?><?php if (isset($karma_all_val['rate_delta']) && $karma_all_val['rate_delta']<0) { echo 'red'; } ?>; ">
            <input type="text" name="karma_rate_count" value="<?php if (isset($karma_all_val['rate_count'])) { echo $karma_all_val['rate_count']; } ?>" disabled="disabled" size="2">
            <input type="text" name="karma_rate_delta_blog_plus" value="<?php if (isset($karma_all_val['rate_delta_blog_plus'])) { echo $karma_all_val['rate_delta_blog_plus']; } ?>" disabled="disabled" size="2">
            <input type="text" name="karma_rate_delta_blog_minus" value="<?php if (isset($karma_all_val['rate_delta_blog_minus'])) { echo $karma_all_val['rate_delta_blog_minus']; } ?>" disabled="disabled" size="2">

           <?php } ?>
           </td>

              <td class="left"><?php echo $comment['status']; ?></td>
              <td class="left"><?php echo $comment['date_added']; ?></td>
              <td class="left"><?php
              foreach ($languages as $lang) {
	              if ($comment['language_id'] == $lang['language_id']) {
	              ?>
				<img src="<?php echo $lang['image']; ?>" title="<?php echo $lang['name']; ?>" />&nbsp;<?php echo $lang['name']; ?>
	              <?php
	              }
              }
              ?></td>

              <td class="right"><?php foreach ($comment['action'] as $action) { ?>
                <a href="<?php echo $action['href']; ?>"  class="markbuttono" style="margin: 2px;"><?php echo $action['text']; ?></a>
                <?php } ?></td>

            </tr>
            <?php } ?>
            <?php } else { ?>
            <tr>
              <td class="center" colspan="7"><?php echo $text_no_results; ?></td>
            </tr>
            <?php } ?>
          </tbody>
        </table>
      </form>
      <div class="pagination"><?php echo $pagination; ?></div>
    </div>
  </div>
</div>

<script type="text/javascript">
function filter() {
	url = 'index.php?route=catalog/comment&action=<?php echo $mark_name; ?>&token=<?php echo $token; ?>';

	var filter_name = $('input[name=\'filter_name\']').prop('value');

	if (filter_name) {
		url += '&filter_name=' + encodeURIComponent(filter_name);
	}

	location = url;
}
</script>
<script type="text/javascript">
$('#form input').keydown(function(e) {
	if (e.keyCode == 13) {
		filter();
	}
});
</script>

<script>
$('input[name=\'filter_name\']').autocomplete({
	'source': function(request, response) {         	<?php
         	if (SC_VERSION < 20) {
         	?>
         	 var irequest = request.term;
         	<?php
         	} else {
         	?>
         	var irequest = request;
         	<?php
         	}
         	?>
		$.ajax({
			url: 'index.php?route=catalog/comment/autocomplete&action=<?php echo $mark_name; ?>&token=<?php echo $token; ?>&filter_name=' +  encodeURIComponent(irequest),
			dataType: 'json',
			success: function(json) {
				response($.map(json, function(item) {
					return {
						label: item.name,
						value: item.record_id
					}
				}));
			}
		});
	},
	'select': function(event, ui) {         	<?php
         	if (SC_VERSION < 20) {
         	?>
         	 var ilabel = ui.item.label;
         	 var ivalue = ui.item.value;
         	<?php
         	} else {
         	?>
         		var ilabel = event['label'];
         		var ivalue = event['value'];
         	<?php
         	}
         	?>
		$('input[name=\'filter_name\']').val(ilabel);

		return false;
	}
});
</script>


</div>
<?php echo $footer; ?>
