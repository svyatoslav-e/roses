<div class="panel panel-default filter_block hidden-sm hidden-xs">
  <div class="panel-heading"><?php echo $heading_title; ?></div>
  <div class="list-group">
    <?php foreach ($filter_groups as $filter_group) { ?>
<!--     <a class="list-group-item"><?php echo $filter_group['name']; ?></a> -->
    <div class="list-group-item">
      <div id="filter-group<?php echo $filter_group['filter_group_id']; ?>">
        <?php foreach ($filter_group['filter'] as $filter) { ?>
        <div class="filter">
          <label class="filter__label" for="filter_<?php echo $filter['filter_id']; ?>">
            <?php echo $filter['name']; ?>
          </label>
            <?php if (in_array($filter['filter_id'], $filter_category)) { ?>
            <input type="checkbox" name="filter[]" value="<?php echo $filter['filter_id']; ?>" checked="checked" id="filter_<?php echo $filter['filter_id']; ?>" class="filter__inpt" />
            <?php } else { ?>
            <input type="checkbox" name="filter[]" value="<?php echo $filter['filter_id']; ?>" id="filter_<?php echo $filter['filter_id']; ?>" class="filter__inpt" />
            <?php } ?>
        </div>
        <?php } ?>
      </div>
    </div>
    <?php } ?>
  </div>
  <div class="panel-footer text-right">
    <button type="button" id="button-filter" class="dtn-roses btn-orange"><?php echo $button_filter; ?></button>
  </div>
</div>
<script type="text/javascript"><!--
$('#button-filter').on('click', function() {
	filter = [];

	$('input[name^=\'filter\']:checked').each(function(element) {
		filter.push(this.value);
	});

	location = '<?php echo $action; ?>&filter=' + filter.join(',');
});
//--></script>

<script>
var offsetFilter =  $('.filter_block').offset().top;
$(window).scroll(function(){
  var scrollHF = $(this).scrollTop();
  if (scrollHF >= offsetFilter){
   $('.filter_block').offset({top:scrollHF});
  }
});

</script>
