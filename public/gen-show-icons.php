<?php

function gen_show_icons(){
    global $wpdb;
    $query = "SELECT * FROM {$wpdb->prefix}gen_icons";
    $icons_list = $wpdb->get_results($query, ARRAY_A);

    if(empty($icons_list)){
        $icons_list = null;
    } else {
        ?>
        <div class="gen-float-icons">
            <ul class="gen-float-icons__list">
                <?php foreach($icons_list as $item):?>
                    <li class="gen-float-icons__list__item">
                        <span class="gen-float-icons__list__label"><?php echo $item['title']; ?></span>
                        <a class="gen-float-icons__list__link" href="<?php echo $item['link']; ?>">
                            <i class="fab fa-twitter"></i>
                        </a>
                    </li>
                <?php endforeach; ?>
            </ul>
        </div>
        <?php
    }
}

add_action( 'wp_footer', 'gen_show_icons' );