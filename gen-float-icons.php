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

require_once('includes/gen-float-icons-activator.php');
register_activation_hook(__FILE__,'gen_activate' );


require_once('includes/gen-float-icons-deactivator.php');
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
        plugin_dir_url(__FILE__).'admin/img/gen-icon-plugin-02-01.png',
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

    wp_localize_script( 'gen-main', 'ajaxOnOffGen', [
        'url' => admin_url('admin-ajax.php'),
        'security' => wp_create_nonce( 'segur' )
    ]);

    wp_localize_script( 'gen-main', 'ajaxUpdOrder', [
        'url' => admin_url('admin-ajax.php'),
        'security' => wp_create_nonce( 'geniorama' )
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

/**
 * AJAX FUNCTIONS
 */

add_action( 'wp_ajax_requestDelete', 'gen_delete_icon' );
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

add_action('wp_ajax_nopriv_gen_change_status_icons', 'gen_on_off_status');
add_action( 'wp_ajax_gen_change_status_icons', 'gen_on_off_status');

function gen_on_off_status(){
    global $wpdb;
    $nonce = $_POST['nonce'];
    
    if(!wp_verify_nonce($nonce, 'segur')){
        die('No tiene permisos para realizar esta acción');
    }
    $iconStatus = $_POST['iconStatus'];
    $nameTable = $_POST['table'];

    
    $tableIconsGen = $wpdb->prefix . $nameTable;

    if(isset($_POST['iconStatus'])){
        $data = array(
            'iconStatus' => $iconStatus
        );

        if($_POST['table'] == "gen_icons"){
            $upResGen = $wpdb->update($tableIconsGen, $data, array('IconId' => $_POST['id']));
        }

        if($_POST['table'] == "gen_icons_general"){
            $upResGen = $wpdb->update($tableIconsGen, $data, array('id' => $_POST['id']));
        }
        
    }
    return true;
    die;
}

add_action('wp_ajax_nopriv_gen_upd_order', 'gen_upd_order_items');
add_action( 'wp_ajax_gen_upd_order', 'gen_upd_order_items');

function gen_upd_order_items(){
    global $wpdb;
    $nonce = $_POST['nonce'];
    
    if(!wp_verify_nonce($nonce, 'geniorama')){
        die('No tiene permisos para realizar esta acción');
    }

    $arr = $_POST['items'];
    $tableIcons = "{$wpdb->prefix}gen_icons";

    foreach($arr as $item){
        $idOld = $item['oldId'];
        $rewuard_ids = $wpdb->get_results("SELECT * FROM $tableIcons WHERE iconOrder = $idOld");
        
        // $wpdb->update($tableIcons, 
        // array(
        //     'iconOrder' => $item['currId']
        // ), 
        // array('iconOrder' => $item['oldId']));
    }
    wp_die();
}

function gen_load(){
    require_once(plugin_dir_path( __FILE__ ) . 'public/gen-show-icons.php');
}


add_action( 'plugins_loaded', 'gen_load' ); 