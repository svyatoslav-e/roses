<div class="list-group category_side">
  <?php foreach ($categories as $category) { ?>
  <? if($category['category_id'] == $category_id) {?>
  <? $classShow = "showing_it"?>
  <?php } else { ?>
  <? $classShow = ""?>
  <?php } ?>

  <?php if ($category['children']) { ?>

  <a href="<?php echo $category['href']; ?>" class="list-group-item active cat_<?php echo $category['category_id']; ?> visible-lg visible-md"><?php echo $category['name']; ?></a>

  <a href="javascript:void(0)" class="main-category list-group-item active cat_<?php echo $category['category_id']; ?> visible-xs visible-sm"><?php echo $category['name']; ?></a>

  <ul class="nav slider-category <?=$classShow; ?>">
        <?php foreach ($category['children'] as $child) { ?>
        <?php if ($child['category_id'] == $child_id) { ?>
        <li><a href="<?php echo $child['href']; ?>" class="list-group-item active">&nbsp;&nbsp;&nbsp;- <?php echo $child['name']; ?></a></li>
        <?php } else { ?>
        <li><a href="<?php echo $child['href']; ?>" class="list-group-item">&nbsp;&nbsp;&nbsp;- <?php echo $child['name']; ?></a></li>
        <?php } ?>
        <?php } ?>
  </ul>
  <?php } else { ?>
    <a href="<?php echo $category['href']; ?>" class="list-group-item active cat_<?php echo $category['category_id']; ?>"><?php echo $category['name']; ?></a>
  <?php } ?>
  <?php } ?>
</div>
<script>
(function (){
  $('.main-category').click(function(){
    $(this).next(".slider-category").slideToggle();
  });
})();
</script>
