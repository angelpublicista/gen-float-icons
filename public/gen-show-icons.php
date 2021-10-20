<?php

function gen_show_icons(){
    global $wpdb;
    $query = "SELECT * FROM {$wpdb->prefix}gen_icons";
    $icons_list = $wpdb->get_results($query, ARRAY_A);

    $queryGen = "SELECT * FROM {$wpdb->prefix}gen_icons_general";
    $data_gen = $wpdb->get_results($queryGen, ARRAY_A);
    

    if(empty($icons_list)){
        $icons_list = null;
    } else {
        ?>
        <div class="gen-float-icons">
            <ul class="gen-float-icons__list">
                <?php foreach($icons_list as $item):
                    $dataIcon = $item['data'];
                    $arrDataIcon = json_decode($dataIcon);
                    $id_icon = strtolower($item['title'] . '-' . $item['IconId']);

                    $dataCss = array(
                        'bgColor' => $arrDataIcon->bgColor,
                        'bgColorHover' => $arrDataIcon->bgColor_hover,
                        'colorIcon' => $arrDataIcon->colorIcon,
                        'colorIconHover' => $arrDataIcon->colorIcon_hover,
                    );

                    $json_data_css = json_encode($dataCss);

                    ?>
                    <?php if($item['iconStatus'] == "on" && $data_gen != null): ?>

                    <style>
                        /* Dynamic styles */
                        <?php echo "#". $id_icon; ?> .gen-float-icons__list__link{
                            background: <?php echo $arrDataIcon->bgColor ?> !important;
                            color: <?php echo $arrDataIcon->colorIcon ?> !important;
                        }

                        <?php echo "#".$id_icon; ?> .gen-float-icons__list__link:hover{
                            background: <?php echo $arrDataIcon->bgColor_hover ?> !important;
                            color: <?php echo $arrDataIcon->colorIcon_hover ?> !important;
                        }

                        <?php echo "#". $id_icon; ?> .gen-float-icons__list__link:active{
                            background: <?php echo $arrDataIcon->bgColor ?> !important;
                            color: <?php echo $arrDataIcon->colorIcon ?> !important;
                        }
                    </style>
                    <li id='<?php echo $id_icon; ?>' class="gen-float-icons__list__item gen-float-icons__item-data">
                        <span class="gen-float-icons__list__label" style="text-align: <?php echo $arrDataIcon->alignLabelText; ?>"><?php echo $item['title']; ?></span>
                        <a 
                            class="gen-float-icons__list__link gen-link <?php echo $arrDataIcon->style ?>" 
                            href="<?php echo $arrDataIcon->link; ?>"
                            target="_blank">
                            <i class="<?php echo $arrDataIcon->faIcon; ?>"></i>
                        </a>
                    </li>
                    <?php endif; ?>
                <?php endforeach; ?>

                <?php foreach($data_gen as $item): 
                    $dataItem = $item['data'];
                    $decodeDataItem = json_decode($dataItem);
                    ?>
                    <?php if($item['iconStatus'] == "on" && $data_gen != null): ?>
                    <li class="gen-float-icons__list__item">
                        <?php if($decodeDataItem->textLabelClose): ?>
                            <span class="gen-float-icons__list__label" style="text-align:<?php echo $decodeDataItem->alignLabelTextGen; ?>">
                                <?php echo $decodeDataItem->textLabelClose; ?>
                            </span>
                        <?php endif; ?>
                        <a class="gen-float-icons__list__link gen-link-toggle" href="#">
                            <i class="fas fa-comment-dots"></i> 
                        </a>
                    </li>
                    <?php endif; ?>
                <?php endforeach; ?>
            </ul>
        </div>
        <?php
    }
}

add_action( 'wp_footer', 'gen_show_icons' );