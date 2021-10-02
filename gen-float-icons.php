<?php

/**
 * Plugin Name: Gen Float Icons
 * Plugin URI: http://www.mywebsite.com/my-first-plugin
 * Description: The very first plugin that I have ever created.
 * Version: 1.0
 * Author: Angel Burgos
 * Author URI: http://www.mywebsite.com
 */

if(!defined('ABSPATH')){
    define('ABSPATH', dirname(__FILE__) . '/');
}

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
        PRIMARY KEY (IconId)
    );";

    $wpdb->query($genQuery);
    
    // Second Table
    $gen_table_name_2 = $wpdb->prefix . 'gen_icons_general';

    $genQuery2 = "CREATE TABLE IF NOT EXISTS " . $gen_table_name_2 . "(
        id int(11) NOT NULL AUTO_INCREMENT,
        textLabelClose varchar(45) NOT NULL,
        alignLabelTextGen varchar(45) NOT NULL,
        PRIMARY KEY (id)
    );";

    $wpdb->query($genQuery2);
}

function gen_deactivate(){
    flush_rewrite_rules();
}

register_activation_hook(__FILE__,'gen_activate' );
register_deactivation_hook(__FILE__,'gen_deactivate');


// Admin Menu
add_action( 'admin_menu', 'gen_create_menu');

function gen_create_menu(){
    add_menu_page(
        'Gen Float Icons',
        'Gen Float Icons',
        'manage_options',
        plugin_dir_path( __FILE__ ).'admin/gen-list-icons.php',
        null,
        plugin_dir_url(__FILE__).'admin/img/gen-icon-plugin-02.svg',
        '8'
    );
}

// Encolar bootstrap
function gen_bootstrap_encoleJS($hook){
    if($hook != "gen-float-icons/admin/gen-list-icons.php"){
       return;
    }
    // Add the color picker css file       
    wp_enqueue_style( 'wp-color-picker' );
    wp_enqueue_style( 'gen-admin-style', plugins_url( 'admin/css/style.css',__FILE__), array(), '1.0');
    wp_enqueue_script('bootstrapJs', 'https://cdnjs.cloudflare.com/ajax/libs/twitter-bootstrap/4.6.0/js/bootstrap.min.js', array('jquery'));
    wp_enqueue_style('gen-font-awesome', 'https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.9.0/css/all.min.css');
    wp_enqueue_script( 'sortableJs', plugins_url( 'admin/js/Sortable.min.js', __FILE__));
    wp_enqueue_script('gen-main', plugins_url( 'admin/js/main.js',__FILE__), array('jquery', 'wp-color-picker', 'sortableJs'));
    wp_localize_script( 'gen-main', 'ajaxRequest', [
        'url' => admin_url('admin-ajax.php'),
        'security' => wp_create_nonce( 'seg' )
    ]);
}

add_action( 'admin_enqueue_scripts', 'gen_bootstrap_encoleJS');

function gen_bootstrap_encoleCSS($hook){
    if($hook != "gen-float-icons/admin/gen-list-icons.php"){
        return;
    }
    wp_enqueue_style('bootstrapCss', 'https://cdnjs.cloudflare.com/ajax/libs/twitter-bootstrap/4.6.0/css/bootstrap.min.css');
}

add_action( 'admin_enqueue_scripts', 'gen_bootstrap_encoleCSS');

// Scripts
// Register Scripts
add_action( 'init','gen_register_scripts');
function gen_register_scripts() {
    wp_register_style( 'gen-general-styles', plugins_url( 'public/css/style.css', __FILE__ )  );
    wp_register_style('gen-font-awesome', 'https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.9.0/css/all.min.css');
    wp_register_script( 'gen-main-public', plugins_url( 'public/js/main.js', __FILE__ ), array('jquery'), '1.0');
}

// Enqueue Scripts
add_action( 'wp_enqueue_scripts', 'gen_style_encoleCSS');
function gen_style_encoleCSS(){
    wp_enqueue_style( 'gen-general-styles');
    wp_enqueue_style('gen-font-awesome');
    wp_enqueue_script('gen-main-public');
}



// Ajax
function gen_delete_icon(){
    $nonce = $_POST['nonce'];
    if(!wp_verify_nonce($nonce, 'seg')){
        die('No tiene permisos para realizar esta acción');
    }

    $id = $_POST['id'];

    global $wpdb;
    $tableIcons = "{$wpdb->prefix}gen_icons";
    $wpdb->delete($tableIcons, array('IconId' => $id));
    return true;
}

add_action( 'wp_ajax_requestDelete', 'gen_delete_icon' );

function gen_load(){
    
    require_once(plugin_dir_path( __FILE__ ) . 'public/gen-show-icons.php');
}


add_action( 'plugins_loaded', 'gen_load' ); 