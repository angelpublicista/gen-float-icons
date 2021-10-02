<?php

function gen_show_icons(){
    global $wpdb;
    $query = "SELECT * FROM {$wpdb->prefix}gen_icons";
    $icons_list = $wpdb->get_results($query, ARRAY_A);

    $queryGen = "SELECT * FROM {$wpdb->prefix}gen_icons_general";
    $data_gen = $wpdb->get_results($queryGen, ARRAY_A);

    if(empty($icons_list) && empty($data_gen)){
        $icons_list = null;
        $data_gen = null;
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
                        <a 
                            class="gen-float-icons__list__link gen-link <?php echo $item['style'] ?>" 
                            href="<?php echo $item['link']; ?>"
                            target="_blank">
                            <i class="<?php echo $item['faIcon']; ?>"></i>
                        </a>
                        <span class="gen-float-icons__list__label" style="text-align: <?php echo $item['alignLabelText']; ?>"><?php echo $item['title']; ?></span>
                    </li>
                <?php endforeach; ?>

                <?php foreach($data_gen as $item): ?>
                    <li class="gen-float-icons__list__item">
                        
                        <a class="gen-float-icons__list__link gen-link-toggle" href="#">
                            <i class="fas fa-comment-dots"></i> 
                        </a>
                        <?php if($item['textLabelClose']): ?>
                        <span class="gen-float-icons__list__label" style="text-align:<?php echo $item['alignLabelTextGen']; ?>">
                            <?php echo $item['textLabelClose']; ?>
                        </span>
                        <?php endif; ?>
                    </li>
                <?php endforeach; ?>
            </ul>
        </div>
        <?php
    }
}

add_action( 'wp_footer', 'gen_show_icons' );