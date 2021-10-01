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
                <?php foreach($icons_list as $item):
                    $dataCss = array(
                        'bgColor' => $item['bgColor'],
                        'bgColorHover' => $item['bgColor_hover'],
                        'colorIcon' => $item['colorIcon'],
                        'colorIconHover' => $item['colorIcon_hover'],

                    );

                    $json_data_css = json_encode($dataCss);
                    
                    ?>
                    <li data-css='<?php echo $json_data_css; ?>' class="gen-float-icons__list__item gen-float-icons__item-data">
                        <span class="gen-float-icons__list__label"><?php echo $item['title']; ?></span>
                        <a 
                            class="gen-float-icons__list__link gen-link <?php echo $item['style'] ?>" 
                            href="<?php echo $item['link']; ?>"
                            target="_blank">
                            <i class="<?php echo $item['faIcon']; ?>"></i>
                        </a>
                    </li>
                <?php endforeach; ?>
                    <li class="gen-float-icons__list__item">
                        <span class="gen-float-icons__list__label">
                            ¡Hablemos!
                        </span>
                        <a class="gen-float-icons__list__link gen-link-toggle" href="#">
                            <i class="fas fa-comment-dots"></i> 
                        </a>
                    </li>
            </ul>
        </div>
        <?php
    }
}

add_action( 'wp_footer', 'gen_show_icons' );