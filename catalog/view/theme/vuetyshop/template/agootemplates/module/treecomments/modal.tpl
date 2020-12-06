<div class="container_comments" id="container_comments_<?php echo $mark;?>_<?php echo $mark_id;?>" style="display: none;">
	<noindex>
		<div class="container_comments_vars acc<?php echo $cmswidget; ?>" id="container_comments_vars_<?php echo $mark;?>_<?php echo $mark_id;?>" style="display: none">
			<div class="mark" data-text="<?php echo $mark; ?>"></div>
			<div class="mark_id" data-text="<?php echo $mark_id; ?>"></div>
			<div class="text_rollup_down" data-text="<?php echo $text_rollup_down; ?>"></div>
			<div class="text_rollup" data-text="<?php echo $text_rollup; ?>"></div>
			<div class="visual_editor" data-text="<?php echo $visual_editor; ?>"></div>
			<div class="sorting" data-text="<?php echo $sorting; ?>"></div>
			<div class="page" data-text="<?php echo $page; ?>"></div>
			<div class="ascp_widgets_position" data-text="<?php echo $ascp_widgets_position; ?>"></div>
			<div class="text_voted_blog_plus" data-text="<?php echo  $text_voted_blog_plus; ?>"></div>
			<div class="text_voted_blog_minus" data-text="<?php echo  $text_voted_blog_minus; ?>"></div>
			<div class="text_all" data-text="<?php echo  $text_all; ?>"></div>
			<div class="prefix" data-text="<?php echo $prefix;?>"></div>
		</div>
	</noindex>
<?php  if (isset($mycomments) && $mycomments) {  ?>

<?php
	$opendiv=0;
	foreach ($mycomments as $number => $comment) {
    	$opendiv++;
?>

<div id="comment_link_<?php  echo $comment['comment_id']; ?>" class="<?php echo $prefix;?>form_customer_pointer comment_content level_<?php  echo $comment['level']; ?>" style="overflow: hidden; ">

<div class="container_comment_vars" id="container_comment_<?php echo $mark;?>_<?php echo $mark_id;?>_<?php echo  $comment['comment_id']; ?>" style="display: none">
	<div class="comment_id"><?php echo  $comment['comment_id']; ?></div>
</div>

<div class="padding10">
<b><?php  echo $comment['author']; ?></b>
<?php if (isset($settings_widget['rating']) && $settings_widget['rating'] && $comment['rating_mark']==0 ) { ?>

<?php } ?>

<?php  if (isset($record_comment['karma']) && $record_comment['karma']) { ?>
<div class="voting  <?php  if ($comment['customer_delta'] < 0) echo 'voted_blog_minus';  if ($comment['customer_delta'] > 0) echo 'voted_blog_plus';?> floatright"  id="voting_<?php  echo $comment['comment_id']; ?>">
<?php if (!$comment['customer']){ ?>
<a href="#" class="textdecoration_none">
<ins  class="hrefajax customer_enter">
	<span class="blog_minus" title="<?php echo  $language->get('text_vote_will_reg'); ?>"></span>
	<span class="blog_plus" title="<?php echo  $language->get('text_vote_will_reg'); ?>"></span>
</ins>
</a>
<?php } else { ?>


					<a href="#blog_minus"  title="<?php echo  $language->get('text_vote_blog_minus'); ?>" class="karma_minus blog_minus comments_vote" ></a>
					<a href="#blog_plus"  title="<?php echo  $language->get('text_vote_blog_plus'); ?>" class="karma_plus blog_plus comments_vote" ></a>
<?php } ?>
					<div class="mark <?php  if($comment['delta']>=0) {  echo 'positive'; } else {  echo 'negative'; } ?> " >
						<span title="Всего <?php  echo $comment['rate_count']; ?>: ↑<?php  echo $comment['rate_count_blog_plus']; ?> и ↓<?php  echo $comment['rate_count_blog_minus']; ?>" class="score"><?php  if($comment['delta']>0) {  echo '+'; } ?><?php  echo sprintf("%d", $comment['delta']); ?></span>
					</div>
</div>
<?php } ?>
<br>
  <div class="com_date_added"><?php echo $comment['date_added']; ?></div>
   <div class="com_text  color_<?php  if($comment['delta']>=0) {  echo '000'; } else {  echo 'AAA'; } ?>;">

 <?php include(realpath(dirname(__FILE__)).'/../fields_view.tpl'); ?>

 <div class="bbcode-text" id="bbcode-text-<?php echo  $comment['comment_id']; ?>">
  <?php echo $comment['text']; ?>
  </div>

  </div>

  <div class="margintop10">
    <a href="#" id="comment_id_reply_<?php echo $comment['comment_id']; ?>" class="comment_reply comment_buttons hrefajax"><?php
        echo $text_reply_button;
?></a>
  </div>

<?php
        // determine the actual setting the mark rollup
        if (isset($mycomments[$number + 1]['parent_id']) && ($mycomments[$number + 1]['parent_id'] == $comment['comment_id'])) {
?>
	 <div class="floatright" >

	   <a href="#" id="rollup<?php echo $comment['comment_id']; ?>" class="hrefajax comments_rollup"><?php echo $text_rollup; ?></a>

	 </div>
<?php

        }
        // reply form the way we steal from record.tpl :)  through comment_reply js function, of course
?>
 <!-- for reply form -->
 <div class="overflowhidden width100 lineheight1 height1">&nbsp;</div>
 <div id="<?php echo $prefix;?>comment_work_<?php echo $comment['comment_id']; ?>" class="<?php echo $prefix;?>comment_work width100 margintop5">
 </div>
</div>
<div id="parent<?php echo $comment['comment_id']; ?>" class="comments_parent">
<?php
		if ($comment['flag_end']>0) {

		 if ($comment['flag_end']>$opendiv) {
		  $comment['flag_end']=$opendiv;
		 }
         //echo " Close div: ".$opendiv;
		for ($i=0; $i<$comment['flag_end']; $i++)
		{
        $opendiv--;

?>
 </div>
</div>
<?php

		}
	}
}
 // for not close div
 if ($opendiv>0 ) {
  for ($i=0; $i<$opendiv; $i++)
  {
?>
 </div>
 </div>
 <?php
   }
 }
?>


<div class="floatright displayinline"><?php  echo $entry_sorting; ?>
<!-- <select name="sorting" class="comments_sorting" onchange="$('#comment').comments(this[this.selectedIndex].value);"> -->
<select name="sorting" class="comments_sorting" onchange="$('#comment').comments(this[this.selectedIndex].value);">
    <option <?php if ($sorting == 'desc')  echo 'selected="selected"'; ?> value="desc"><?php echo $text_sorting_desc; ?></option>
    <option <?php if ($sorting == 'asc')   echo 'selected="selected"'; ?> value="asc"><?php  echo $text_sorting_asc;  ?></option>
</select>

</div>

<div class="pagination"><?php echo $pagination; ?></div>

<?php  }  else { ?>
<div class="content"><?php echo $text_no_comments; ?></div>
<?php
}
?>
</div>





