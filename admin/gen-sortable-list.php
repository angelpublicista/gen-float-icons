<ul id="gen-ul-list">
    <?php $i = 0; ?>
    <?php foreach($icons_list as $key => $value): ?>
        <li data-id='<?php echo $i++; ?>'
            <span class="gen-icon-dragg"><i class="fas fa-arrows-alt"></i></span>
            <span><?php echo $value['title']; ?></span>
            <span><?php echo $value['link']; ?></span>
            <span><a href="#" data-id="<?php echo $value['IconId'] ?>" class="btn btn-secondary btnDelete">Borrar</a></span>
        </li>
    <?php endforeach; ?>
</ul>