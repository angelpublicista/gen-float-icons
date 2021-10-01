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
        PRIMARY KEY (IconId)
    );";

    $wpdb->query($genQuery);
    // require_once(ABSPATH . "wp-admin/includes/upgrade.php");
    // dbDelta($genQuery);
}

function gen_deactivate(){
    flush_rewrite_rules();
}

register_activation_hook(__FILE__,'gen_activate' );
register_deactivation_hook(__FILE__,'gen_deactivate');

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
    wp_enqueue_script('bootstrapJs', 'https://cdnjs.cloudflare.com/ajax/libs/twitter-bootstrap/4.6.0/js/bootstrap.min.js', array('jquery'));
    wp_enqueue_script('gen-main', plugins_url( 'admin/js/main.js',__FILE__), array('jquery'));
}

add_action( 'admin_enqueue_scripts', 'gen_bootstrap_encoleJS');

function gen_bootstrap_encoleCSS($hook){
    if($hook != "gen-float-icons/admin/gen-list-icons.php"){
        return;
    }
    wp_enqueue_style('bootstrapCss', 'https://cdnjs.cloudflare.com/ajax/libs/twitter-bootstrap/4.6.0/css/bootstrap.min.css');
}

add_action( 'admin_enqueue_scripts', 'gen_bootstrap_encoleCSS');
