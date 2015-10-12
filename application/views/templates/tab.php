<!-- Nav tabs -->
<ul class="nav nav-tabs" role="tablist">
    <?php foreach ($page as $val): ?>
    <?php echo $val["page"];?>
    <li role="presentation" class="active"><a href="<?php echo '#'.$val["page"];?>" role="tab" data-toggle="tab"><?php echo $val["page_name"];?></a></li>
    <?php   endforeach; ?>
</ul>
