<?php

function gen_activate(){
    global $wpdb;

    $gen_table_name = $wpdb->prefix . 'gen_icons';

    $genQuery = "CREATE TABLE IF NOT EXISTS " . $gen_table_name . "(
        IconId int(11) NOT NULL AUTO_INCREMENT,
        title varchar(45) NOT NULL,
        link varchar(45) NOT NULL,
        bgColor varchar(45) NULL,
        bgColor_hover varchar(45) NULL,
        style varchar(45) NULL,
        faIcon varchar(100) NULL,
        imgIcon varchar(200) NULL,
        colorIcon varchar(45) NULL,
        colorIcon_hover varchar(45) NULL,
        typeIcon varchar(45) NULL,
        alignLabelText varchar(45) NULL,
        iconStatus varchar(45) NULL,
        iconOrder int(10) NULL,
        PRIMARY KEY (IconId)
    );";

    $wpdb->query($genQuery);
    
    // Second Table
    $gen_table_name_2 = $wpdb->prefix . 'gen_icons_general';

    $genQuery2 = "CREATE TABLE IF NOT EXISTS " . $gen_table_name_2 . "(
        id int(11) NOT NULL AUTO_INCREMENT,
        textLabelClose varchar(45) NOT NULL,
        alignLabelTextGen varchar(45) NOT NULL,
        iconStatus varchar(45) NOT NULL,
        PRIMARY KEY (id)
    );";

    $wpdb->query($genQuery2);

    // Insert demo content
    $tableIconsGen = "{$wpdb->prefix}gen_icons_general";
    $query = "SELECT id FROM $tableIconsGen ORDER BY id DESC limit 1";
    $res = $wpdb->get_results($query, ARRAY_A);
    if(!$res){
        $textLabelClose = 'Hablemos';
        $alignLabelTextGen = 'center';
        $iconStatus = 'off';
        $data = array(
            'textLabelClose' => $textLabelClose,
            'alignLabelTextGen' => $alignLabelTextGen,
            'iconStatus' => $iconStatus,
        );

        $response = $wpdb->insert($tableIconsGen, $data);
    }
}

