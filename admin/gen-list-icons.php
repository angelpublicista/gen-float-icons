<?php 
    global $wpdb;
    $query = "SELECT * FROM {$wpdb->prefix}gen_icons";
    $icons_list = $wpdb->get_results($query, ARRAY_A);

    if(empty($icons_list)){
        $icons_list = array();
    }
?>
<div class="wrap">
    <h1><?php echo get_admin_page_title(); ?></h1>
    <a href="#" class="btn btn-primary" style="margin: 10px 0; display: inline-block">Añadir nuevo icono</a>
    <table class="wp-list-table widefat fixed striped pages">
        <thead>
            <th>Item</th>
            <th>Item</th>
            <th>Item</th>
        </thead>
        <tbody id="gen-icon-list">
            <?php foreach($icons_list as $key => $value): ?>
            <tr>
                <td><?php echo $value['title']; ?></td>
                <td><?php echo $value['link']; ?></td>
                <td >
                   <a href="#" class="btn btn-primary">Editar</a> 
                   <a href="#" class="btn btn-secondary">Borrar</a> 
                </td>
            </tr>
            <?php endforeach; ?>
        </tbody>
    </table>
</div>