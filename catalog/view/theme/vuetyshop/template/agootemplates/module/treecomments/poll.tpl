<div class="container_comments" id="container_comments_<?php echo $mark;?>_<?php echo $mark_id;?>">
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

	<?php
	if (isset($mycomments) && $mycomments) {	  	if (isset($record_comment['admin_name']) && $record_comment['admin_name']) {
			$admin_name =  array_flip(explode(";",trim($record_comment['admin_name'])));
		}


		$karma_all = 0;
		$voted_all = 0;


		foreach ($mycomments as $number => $comment) {
			$karma_all = $karma_all + $comment['customer_delta'];
			$voted_all = $voted_all + $comment['rate_count'];
		}
		reset($mycomments);

		$admin = false;
		$opendiv=0;
		foreach ($mycomments as $number => $comment) {
		$opendiv++;
		if (isset($admin_name[trim($comment['author'])])) {		 $back_color = 'background-color: '.$record_comment['admin_color'].';';
		 $admin = true;
		} else {		 $back_color ='';
		 $admin = false;
		}
	?>

	<div id="comment_link_<?php  echo $comment['comment_id']; ?>" class="<?php echo $prefix;?>form_customer_pointer comment_content level_<?php  echo $comment['level']; ?>">

		<div class="container_comment_vars" id="container_comment_<?php echo $mark;?>_<?php echo $mark_id;?>_<?php echo  $comment['comment_id']; ?>" style="display: none">
			<div class="comment_id"><?php echo  $comment['comment_id']; ?></div>
		</div>

		<div class="padding10" style="<?php echo $back_color; ?>">
			<div class="com_text color_<?php  if($comment['delta']>=0) {  echo '000'; } else {  echo 'aaa'; } ?>">

			<?php include(realpath(dirname(__FILE__)).'/../fields_view.tpl'); ?>

			<div class="bbcode-text" id="bbcode-text-<?php echo  $comment['comment_id']; ?>">
                <?php if ($karma_voted) { ?>
                 <?php echo $comment['text']; ?>
                <?php } else { ?>
				<a href="#blog_plus"   data-cmswidget="<?php echo $cmswidget; ?>" title="<?php echo  $language->get('text_vote_blog_plus'); ?>"   class="comment_yes blog_plus comments_vote <?php if (isset($comment['voted']) && $comment['voted']) echo "voted_comment_plus"; ?>" ><?php echo $comment['text']; ?></a>
                <?php } ?>


			</div>

			</div>


           <!-- karma -->
			<?php  if (isset($record_comment['karma']) && $record_comment['karma']) { ?>
			<div class="voting  <?php  if ($comment['customer_delta'] < 0) echo 'voted_blog_minus';  if ($comment['customer_delta'] > 0) echo 'voted_blog_plus';?> floatright marginright90px"  id="voting_<?php  echo $comment['comment_id']; ?>">

				<?php
				if (!$comment['customer'] && (isset($thislist['karma_reg']) && $thislist['karma_reg']==1) ){ ?>

				<div class="floatright marginleft10">
                <span class="comments_stat <?php echo $prefix;?>voted"><?php if ($comment['rate_count_blog_plus']!="0")    { ;?><span class="score_plus"><?php  echo $comment['rate_count_blog_plus'];?></span><?php    } else { ?><span class="score_plus"></span><?php  } ?></span>

				<?php

				// echo  $language->get('text_vote_will_reg');

				?>

				</div>

				<?php } else { ?>
				<div class="floatright marginleft10">

				<span class="comments_stat <?php echo $prefix;?>voted"><?php if ($comment['rate_count_blog_plus']!="0")    { ;?><span class="score_plus"><?php  echo $comment['rate_count_blog_plus'];?></span><?php    } else { ?><span class="score_plus"></span><?php  } ?></span>
				<a href="#blog_plus"   data-cmswidget="<?php echo $cmswidget; ?>" title="<?php echo  $language->get('text_vote_blog_plus'); ?>"   class="comment_yes blog_plus comments_vote <?php if (isset($comment['voted']) && $comment['voted']) echo "voted_comment_plus"; ?>" ><?php echo $language->get('text_review_yes'); ?></a>
				</div>
				<?php } ?>

				<div class="mark <?php  if($comment['delta']>=0) {  echo 'positive'; } else {  echo 'negative'; } ?> <?php echo $prefix;?>voted" >
					<span title="All <?php  echo $comment['rate_count']; ?>: ↑<?php  echo $comment['rate_count_blog_plus']; ?> & ↓<?php  echo $comment['rate_count_blog_minus']; ?>" class="score">
					<!-- <?php  if($comment['delta']>0) {  echo '+'; } ?><?php  echo sprintf("%d", $comment['delta']); ?> -->
					</span>
				</div>

			</div>
			<?php } ?>
             <!-- karma -->

 <div class="<?php echo $prefix;?>voted">
<?php
if  ($voted_all>0) {
echo round(($comment['rate_count']/$voted_all)*100)."%";
}
?>

					<?php if ($theme_stars && $voted_all!=0) { ?>
					<img style="height: 10px; width:<?php echo round(($comment['rate_count']/$voted_all)*100)."%";?>"  title="<?php echo $comment['rating']; ?>" alt="<?php echo $comment['rating']; ?>" src="catalog/view/theme/<?php echo $theme_stars; ?>/image/color1.jpg">
					<?php } ?>

     </div>






			<?php
			// determine the actual setting the mark rollup
			if (isset($mycomments[$number + 1]['parent_id']) && ($mycomments[$number + 1]['parent_id'] == $comment['comment_id']))
			{
			?>
			<div class="floatright" >

				<a href="#" id="rollup<?php echo $comment['comment_id']; ?>" class="hrefajax comments_rollup" data-cmswidget="<?php echo $cmswidget; ?>"><?php echo $text_rollup; ?></a>

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

<!--
<div class="floatright displayinline"><?php  echo $entry_sorting; ?>
	<select name="sorting" data-cmswidget="<?php echo $cmswidget; ?>" class="comments_sorting" onchange="$('#comment').comments(this[this.selectedIndex].value);">
		<option <?php if ($sorting == 'desc')  echo 'selected="selected"'; ?> data-cmswidget="<?php echo $cmswidget; ?>" value="desc"><?php echo $text_sorting_desc; ?></option>
		<option <?php if ($sorting == 'asc')   echo 'selected="selected"'; ?> data-cmswidget="<?php echo $cmswidget; ?>" value="asc"><?php  echo $text_sorting_asc;  ?></option>
	</select>
</div>
<div class="pagination"><?php echo $pagination; ?></div>
-->




<div class="margintop10 marginbottom10 <?php echo $prefix;?>voted">
<?php echo $language->get('text_all'); ?><?php echo $voted_all; ?>
</div>


				<?php
				if (!$comment['customer'] && (isset($thislist['karma_reg']) && $thislist['karma_reg']==1) ){ ?>

				<div>

				<?php echo  $language->get('text_vote_will_reg'); ?>

				</div>

				<?php } ?>



<div class="margintop10 marginbottom10">
<a href="#" onclick="$('.<?php echo $prefix;?>voted').show(); return false" class="hrefajax"><?php echo $language->get('text_result'); ?></a>
</div>


<?php  }  else { ?>
<div class="content"><?php echo $text_no_comments; ?></div>
<?php
}
?>
</div>
<script>
<?php
$tab_review = sprintf($language->get('tab_review'), $comment_total);
?>
$(document).ready(function(){var tab_selector = '#tab-review';
$('a[href=\''+tab_selector+'\']').html('<?php echo $tab_review; ?>');

<?php if ($comment_total < 1) { ?>
$('.leavereview').hide();
<?php } ?>


});
</script>

<script>
<?php if ($karma_voted) { ?>

	$('.<?php echo $prefix;?>voted').show();
	$('#cmswidget-<?php echo $cmswidget; ?> .comments_vote').hide();

<?php } ?>

</script>