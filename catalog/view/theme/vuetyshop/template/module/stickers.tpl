<?
if($stickers){
  $stickers_count = count($stickers);

  foreach ($stickers as $sticker) {?>
<?if ($sticker['status']){?>

<? if($sticker['id'] =='1' && $sticker['new']){?> 
     <div style="position:absolute; <?=$sticker['styles']?>" class="sticker">
      <img src="<?=$sticker['image']?>" alt="<?=$sticker['name']?>">
    </div>
<?}else if($sticker['id'] =='3' && $sticker['bestseller']){?>
     <div style="position:absolute; <?=$sticker['styles']?>" class="sticker">
      <img src="<?=$sticker['image']?>" alt="<?=$sticker['name']?>">
    </div>

<?}else if($sticker['id'] =='2' && $sticker['special']){?>
     <div style="position:absolute; <?=$sticker['styles']?>" class="sticker">
      <img src="<?=$sticker['image']?>" alt="<?=$sticker['name']?>">
    </div>
<?}?>

<?}?>

  <?}
}
