<?php 
    global $wpdb;

    $tableIcons = "{$wpdb->prefix}gen_icons";
    if(isset($_POST['btnSave'])){
        $title = $_POST['title'];
        $link = $_POST['link'];
        $bgColor = $_POST['bgColor'];
        $bgColorHover = $_POST['bgColorHover'];
        $styleIcon = $_POST['styleIcon'];
        $faIcon= $_POST['faIcon'];
        $iconColor = $_POST['iconColor'];
        $iconColorHover = $_POST['iconColorHover'];
        $typeIcon = $_POST['typeIcon'];
        $alignLabelText = $_POST['alignLabelText'];
        
        $query = "SELECT IconId FROM $tableIcons ORDER BY IconId DESC limit 1";
        $res = $wpdb->get_results($query, ARRAY_A);
        $nextId = $res[0]['IconId'] + 1;
        $data = array(
            'IconId' => null,
            'title' => $title,
            'link' => $link,
            'bgColor' => $bgColor,
            'bgColor_hover' => $bgColorHover,
            'style' => $styleIcon,
            'faIcon' => $faIcon,
            'imgIcon' => null,
            'colorIcon' => $iconColor,
            'colorIcon_hover' => $iconColorHover,
            'colorIcon_hover' => $typeIcon,
            'alignLabelText' => $alignLabelText
        );

        $response = $wpdb->insert($tableIcons, $data);
    }

    $query = "SELECT * FROM {$wpdb->prefix}gen_icons ORDER BY iconOrder";
    $icons_list = $wpdb->get_results($query, ARRAY_A);

    if(empty($icons_list)){
        $icons_list = array();
    }

    if(isset($_POST['btnUpdate'])){
        $id = intval($_POST['idIcon']);
        $title = $_POST['title'];
        $link = $_POST['link'];
        $bgColor = $_POST['bgColor'];
        $bgColorHover = $_POST['bgColorHover'];
        $styleIcon = $_POST['styleIcon'];
        $faIcon= $_POST['faIcon'];
        $iconColor = $_POST['iconColor'];
        $iconColorHover = $_POST['iconColorHover'];
        $typeIcon = $_POST['typeIcon'];
        $alignLabelText = $_POST['alignLabelText'];

        $upRes = $wpdb->update($tableIcons, 
                array(
                    'title' => $title,
                    'link' => $link,
                    'bgColor' => $bgColor,
                    'bgColor_hover' => $bgColorHover,
                    'style' => $styleIcon,
                    'faIcon' => $faIcon,
                    'imgIcon' => null,
                    'colorIcon' => $iconColor,
                    'colorIcon_hover' => $iconColorHover,
                    'typeIcon' => $typeIcon,
                    'alignLabelText' => $alignLabelText
                ),

                array(
                    'IconId' => $id
                )
        );

        if($upRes){
            ?>
                <script type="text/javascript">
                    document.location.reload(true);
                </script>
            <?php
        }
    }

    $queryGen = "SELECT * FROM {$wpdb->prefix}gen_icons_general";
    $data_gen = $wpdb->get_results($queryGen, ARRAY_A);

    if(empty($data_gen)){
        $data_gen = array();
    }


    $tableIconsGen = "{$wpdb->prefix}gen_icons_general";
    if(isset($_POST['btnSaveGeneral'])){
        $textLabelClose = $_POST['textLabelClose'];
        $alignLabelTextGen = $_POST['alignLabelTextGen'];
        $data = array(
            'textLabelClose' => $textLabelClose,
            'alignLabelTextGen' => $alignLabelTextGen,
        );
        $upResGen = $wpdb->update($tableIconsGen, $data, array('id' => $_POST['idGen']));

        if($upResGen){
            ?>
                <script type="text/javascript">
                    document.location.reload(true);
                </script>
            <?php
        }

    }

?>
<div class="wrap" style="padding: 2em">
    <div style="display:flex; align-items: center">
        <h1 class="admin-title-gen"><?php echo get_admin_page_title(); ?></h1>
        <!-- Button on of -->
        <?php foreach($data_gen as $item): ?>
        <button id="gen-btn-content" class="btn-on-off <?php if($item['iconStatus'] == 'on'){echo "stat-on";}else{ echo "stat-off";} ?>" data-table="gen_icons_general" data-id="<?php echo $item['id']; ?>"></button>
        <?php endforeach; ?>
    </div>
    
    <div class="gen-admin-content">
        <!-- General Config -->
        <div class="row my-3">
            <div class="col-12 col-md-6">
            <h5>Configuración general</h5>
            <form action="" method="post" class="mt-3" id="gen-form-upd-general">
                <?php foreach($data_gen as $data): ?>
                <fieldset>
                    <h6>Botón de apertura</h6>
                    <input type="hidden" name="idGen" id="idGen" value="<?php echo $data['id']; ?>">
                    <div class="form-group form-inline">
                        <label for="" class="mr-3">Texto</label>
                        <input type="text" class="form-control mr-1" id="textLabelClose" name="textLabelClose" value="<?php echo $data['textLabelClose']; ?>" disabled>
                    </div>

                    <div class="form-group form-inline">
                        <label for="" class="mr-3">Alineación texto</label>
                        <select name="alignLabelTextGen" id="alignLabelTextGen" class="form-control custom-select mr-1" disabled>
                            <option value="center" <?php if($data['alignLabelTextGen'] == 'center'){ echo "selected";} ?>>Centro</option>
                            <option value="left" <?php if($data['alignLabelTextGen'] == 'left'){ echo "selected";} ?>>Izquierda</option>
                            <option value="right" <?php if($data['alignLabelTextGen'] == 'right'){ echo "selected";} ?>>Derecha</option>
                        </select>
                    </div>
                </fieldset>
                

                <div class="form-group mt-2">
                    <button type="button" class="btn btn-primary" id="btnEditGeneral">Editar</button>
                    <button type="submit" class="btn btn-success" id="btnSaveGeneral" name="btnSaveGeneral" disabled>Guardar</button>
                    <button type="button" class="btn btn-danger" id="btnCancelGeneral" disabled>Cancelar</button>
                </div>
                <?php endforeach; ?>
            </form>
            </div>
        </div>

        <!-- Table Icons -->
        <div class="mb-3 d-flex justify-content-between">
            <a href="#" class="btn btn-primary" data-toggle="modal" data-target="#gen-modal-new">
                <span>Nuevo icono</span>
                <i class="fas fa-plus-circle"></i>
            </a>
            <!-- <div class="d-flex align-items-center">
                <a href="#" class="btn btn-link gen-list-reordering__cancel">Cancelar</a>
                <a href="#" class="btn btn-light ml-2 gen-list-reordering" data-handle="false">
                    <span>Reordenar</span>
                    <i class="fas fa-sort"></i>
                </a>
            </div> -->
        </div>
        
        <table class="wp-list-table widefat fixed striped pages">
            <thead>
                <th><b>#</b></th>
                <th><b>Título</b></th>
                <th><b>Link</b></th>
                <th><b>Estado</b></th>
                <th><b>Acciones</b></th>
            </thead>
            <tbody id="gen-icon-list" class="gen-icon-list">
                <?php $i = 1; ?>
                <?php foreach($icons_list as $key => $value): ?>
                <tr data-id='<?php echo $i++; ?>'>
                    <td>
                        <span class="gen-icon-dragg mr-3">
                            <i class="fas fa-ellipsis-v"></i>
                        </span>
                        <!-- <span><?php //echo $value['iconOrder'] ?></span> -->
                    </td>
                    <td>
                        <?php echo $value['title']; ?>
                    </td>
                    <td><?php echo $value['link']; ?></td>
                    <td>
                        <button id="gen-btn-content" class="btn-on-off <?php if($value['iconStatus'] == 'on'){echo "stat-on";}else{ echo "stat-off";} ?>" data-table="gen_icons" data-id="<?php echo $value['IconId']; ?>"></button>
                    </td>
                    <td >
                    <a 
                        href="#"
                        data-id="<?php echo $value['IconId'] ?>"
                        data-toggle="modal" data-target="#gen-modal-update"
                        class="btn btn-primary btnUpdate"
                        data-res='<?php echo json_encode($value); ?>'
                        >Editar</a> 
                    <a href="#" data-id="<?php echo $value['IconId'] ?>" class="btn btn-secondary btnDelete">Borrar</a> 
                    </td>
                </tr>
                <?php endforeach; ?>
            </tbody>
        </table>
    </div>
</div>

<!-- Modal -->
<div class="modal fade" id="gen-modal-new" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
  <div class="modal-dialog modal-dialog-centered">
    <div class="modal-content">
      <div class="modal-header">
        <h5 class="modal-title" id="exampleModalLabel">Agregar Icono</h5>
        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
          <span aria-hidden="true">&times;</span>
        </button>
      </div>
      <form action="" method="post" id="form-new-item">
        <div class="modal-body">
            <div class="row">
                <div class="col-12 col-md-6">
                    <div class="form-group">
                        <label for="">Título</label>
                        <input name="title" type="text" class="form-control" placeholder="Ej: Facebook">
                    </div>
                </div>
                <div class="col-12 col-md-6">
                    <div class="form-group">
                        <label for="">Link</label>
                        <input name="link" type="text" class="form-control" placeholder="Ej: https://facebook.com">
                    </div>
                </div>
                <div class="col-12">
                    <div class="form-group">
                        <label for="">Alineación texto título</label>
                        <select name="alignLabelText" class="form-control custom-select">
                            <option value="center" selected>Centro</option>
                            <option value="left">Izquierda</option>
                            <option value="right">Derecha</option>
                        </select>
                    </div>
                </div>

                <div class="col-12 col-md-4">
                    <div class="form-group">
                        <label for="" style="display: block">Color Fondo</label>
                        <input name="bgColor" id="bgColor" type="text" class="color-field">
                    </div>
                </div>

                <div class="col-12 col-md-4">
                    <div class="form-group">
                        <label for="" style="display: block">Color Fondo Hover</label>
                        <input name="bgColorHover" id="bgColorHover" type="text" class="color-field">
                    </div>
                </div>

                <div class="col-12 col-md-4">
                    <div class="form-group">
                        <label for="" style="display: block">Estilo</label>
                        <select class="form-control custom-select" name="styleIcon" id="styleIcon">
                            <option selected disabled> Selecciona uno</option>
                            <option value="circle">Circular</option>
                            <option value="rounded">Redondeado</option>
                            <option value="squared">Cuadrado</option>
                        </select>
                    </div>
                </div>

                <div class="col-12 col-md-6">
                    <div class="form-group">
                        <label for="" style="display: block">Icono</label>
                        <select class="form-control custom-select" id="typeIcon">
                            <option selected value="faIcon">Font awesome</option>
                            <option value="customIcon">Personalizado</option>
                        </select>
                    </div>
                </div>
                <div class="col-12 col-md-6">
                    <div class="form-group">
                        <label for="">Icono Font Awesome</label>
                        <input name="faIcon" type="text" class="form-control" placeholder="Ej: fab fa-instagram">
                        <small><i>Ver <a href="https://fontawesome.com/" target="_blank">Font Awesome</a></i></small>
                    </div>
                </div>

                <div class="col-12 col-md-6">
                    <div class="form-group">
                        <label for="" style="display: block">Color Icono</label>
                        <input name="iconColor" id="iconColor" type="text" class="color-field">
                    </div>
                </div>

                <div class="col-12 col-md-6">
                    <div class="form-group">
                        <label for="" style="display: block">Color Icono Hover</label>
                        <input name="iconColorHover" id="iconColorHover" type="text" class="color-field">
                    </div>
                </div>
                
            </div>
        </div>
        <div class="modal-footer">
            <button type="button" class="btn btn-secondary" data-dismiss="modal">Cerrar</button>
            <button type="submit" class="btn btn-primary" id="btnSave" name="btnSave">Guardar</button>
        </div>
      </form>
      
    </div>
  </div>
</div>

<!-- Update Modal -->
<div class="modal fade" id="gen-modal-update" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
  <div class="modal-dialog modal-dialog-centered">
    <div class="modal-content">
      <div class="modal-header">
        <h5 class="modal-title" id="exampleModalLabel">Actualizar Icono</h5>
        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
          <span aria-hidden="true">&times;</span>
        </button>
      </div>
      <form action="" method="post" id="form-new-item">
        <div class="modal-body">
            <div class="row">
                <input type="hidden" name="idIcon" id="idIcon">
                <div class="col-12 col-md-6">
                    <div class="form-group">
                        <label for="">Título</label>
                        <input name="title" id="title" type="text" class="form-control" placeholder="Ej: Facebook">
                    </div>
                </div>
                <div class="col-12 col-md-6">
                    <div class="form-group">
                        <label for="">Link</label>
                        <input name="link" id="link" type="text" class="form-control" placeholder="Ej: https://facebook.com">
                    </div>
                </div>
                <div class="col-12">
                    <div class="form-group">
                        <label for="">Alineación texto título</label>
                        <select name="alignLabelText" id="alignLabelText" class="form-control custom-select">
                            <option value="center" selected>Centro</option>
                            <option value="left">Izquierda</option>
                            <option value="right">Derecha</option>
                        </select>
                    </div>
                </div>
                <div class="col-12 col-md-4">
                    <div class="form-group">
                        <label for="" style="display: block">Color Fondo</label>
                        <input name="bgColor" id="bgColor" type="text" class="color-field">
                    </div>
                </div>

                <div class="col-12 col-md-4">
                    <div class="form-group">
                        <label for="" style="display: block">Color Fondo Hover</label>
                        <input name="bgColorHover" id="bgColorHover" type="text" class="color-field">
                    </div>
                </div>

                <div class="col-12 col-md-4">
                    <div class="form-group">
                        <label for="" style="display: block">Estilo</label>
                        <select class="form-control custom-select" name="styleIcon" id="styleIcon">
                            <option selected disabled> Selecciona uno</option>
                            <option value="circle">Circular</option>
                            <option value="rounded">Redondeado</option>
                            <option value="squared">Cuadrado</option>
                        </select>
                    </div>
                </div>

                <div class="col-12 col-md-6">
                    <div class="form-group">
                        <label for="" style="display: block">Icono</label>
                        <select class="form-control custom-select" id="typeIcon" name="typeIcon">
                            <option selected value="faIcon">Font awesome</option>
                            <option value="customIcon">Personalizado</option>
                        </select>
                    </div>
                </div>
                <div class="col-12 col-md-6">
                    <div class="form-group">
                        <label for="">Icono Font Awesome</label>
                        <input name="faIcon" id="faIcon" type="text" class="form-control" placeholder="Ej: fab fa-instagram">
                        <small><i>Ver <a href="https://fontawesome.com/" target="_blank">Font Awesome</a></i></small>
                    </div>
                </div>

                <div class="col-12 col-md-6">
                    <div class="form-group">
                        <label for="" style="display: block">Color Icono</label>
                        <input name="iconColor" id="iconColor" type="text" class="color-field">
                    </div>
                </div>

                <div class="col-12 col-md-6">
                    <div class="form-group">
                        <label for="" style="display: block">Color Icono Hover</label>
                        <input name="iconColorHover" id="iconColorHover" type="text" class="color-field">
                    </div>
                </div>
                
            </div>
        </div>
        <div class="modal-footer">
            <button type="button" class="btn btn-secondary" data-dismiss="modal">Cerrar</button>
            <button type="submit" class="btn btn-primary" id="btnUpdate" name="btnUpdate">Guardar</button>
        </div>
      </form>
      
    </div>
  </div>
</div>