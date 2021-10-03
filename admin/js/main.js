jQuery(function ($) {
    $('.color-field').wpColorPicker();

    function on_off_icon(status, id, table){
        var myStatus = status

       $.ajax({
           type: 'POST',
           url: ajaxOnOffGen.url,
           data: {
               action: 'gen_change_status_icons',
               nonce: ajaxOnOffGen.security,
               iconStatus: myStatus,
               id: id,
               table: table
           },
           success: function(res){
               console.log(res)
           }

       })
    }

    if($('#gen-btn-content').hasClass('stat-on')){
        $('.gen-admin-content').show()
    }

    $('.btn-on-off').on('click', function(e){
        e.preventDefault();

        var id = $(this).attr('data-id')
        var table = $(this).attr('data-table')

        if($(this).hasClass('stat-off')){
            $(this).removeClass('stat-off')
            $(this).addClass('stat-on')
            on_off_icon('on', id, table)
            
            if(table == "gen_icons_general"){
                $('.gen-admin-content').fadeIn()
            }
        } else {
            $(this).removeClass('stat-on')
            $(this).addClass('stat-off')
            on_off_icon('off', id, table)
            if(table == "gen_icons_general"){
                $('.gen-admin-content').fadeOut()
            }
        }
    })
    

	$(document).on('click', function(e){
        const element = e.target

        // Delete
        if(element.classList.contains('btnDelete')){
            const dataId = element.dataset.id
            const url = ajaxRequest.url;

            $.ajax({
                type: "POST",
                url: url,
                data:{
                    action: "requestDelete",
                    nonce: ajaxRequest.security,
                    id: dataId
                },
                success:function(){
                    alert('Datos borrados')
                    location.reload()
                }
            })
        }
    })

    $('.btnUpdate').on('click', function(){
        var dataRes = jQuery.parseJSON($(this).attr('data-res'))
        // const dataRes = jQuery.parseJSON($(this).attr('data-res'))

        console.log(dataRes)

        var formUpdate = $('#form-new-item')

        $('#gen-modal-update').on('shown.bs.modal', function (event) {

            // idIcon
            $('#gen-modal-update #idIcon').val(`${dataRes.IconId}`)
            $('#gen-modal-update #title').val(`${dataRes.title}`)
            $('#gen-modal-update #link').val(`${dataRes.link}`)
            $("#gen-modal-update #alignLabelText option[value="+dataRes.alignLabelText+"]").attr("selected", true)

            // Color bg
            $('#gen-modal-update #bgColor').val(`${dataRes.bgColor}`)
            $('#gen-modal-update #bgColor').parent().parent().parent().find('.wp-color-result').css('background', `${dataRes.bgColor}`)

            // Color hover bg
            $('#gen-modal-update #bgColorHover').val(`${dataRes.bgColor_hover}`)
            $('#gen-modal-update #bgColorHover').parent().parent().parent().find('.wp-color-result').css('background', `${dataRes.bgColor_hover}`)
            $("#gen-modal-update #styleIcon option[value="+dataRes.style+"]").attr("selected", true)
            $("#gen-modal-update #typeIcon option[value="+dataRes.typeIcon+"]").attr("selected", true)
            $("#gen-modal-update #typeIcon option[value="+dataRes.typeIcon+"]").attr("selected", true)
            $('#gen-modal-update #faIcon').val(`${dataRes.faIcon}`)

            // Color icon
            $('#gen-modal-update #iconColor').val(`${dataRes.colorIcon}`)
            $('#gen-modal-update #iconColor').parent().parent().parent().find('.wp-color-result').css('background', `${dataRes.colorIcon}`)

            // Color icon hover
            $('#gen-modal-update #iconColorHover').val(`${dataRes.colorIcon_hover}`)
            $('#gen-modal-update #iconColorHover').parent().parent().parent().find('.wp-color-result').css('background', `${dataRes.colorIcon_hover}`)

            // wp-color-result
        })
    })

    $('#btnEditGeneral').on('click', function(e) {
        e.preventDefault()
        $('#textLabelClose').attr('disabled', false)
        $('#alignLabelTextGen').attr('disabled', false)
        $('#btnSaveGeneral').attr('disabled', false)

        var initValLabel = $('#textLabelClose').val()
        var initValAlign = $('#alignLabelTextGen').val()

        $('#gen-form-upd-general').on('change', function() {
            if(initValLabel != $('#textLabelClose').val() || initValAlign != $('#alignLabelTextGen').val()){
                $('#btnCancelGeneral').attr('disabled', false)
                
            } else {
                $('#btnCancelGeneral').attr('disabled', true)
            }
        })

        $('#btnCancelGeneral').on('click', function(e) {
            e.preventDefault();

            $('#textLabelClose').val(initValLabel)
            $('#alignLabelTextGen option').attr('selected', false)
            $('#alignLabelTextGen option[value='+initValAlign+']').attr('selected', true)
            
            $('#textLabelClose').attr('disabled', true)
            $('#alignLabelTextGen').attr('disabled', true)
            $('#btnSaveGeneral').attr('disabled', true)
            $('#btnCancelGeneral').attr('disabled', true)
        })
    })

    $('.gen-list-reordering__cancel').hide()
    $('.gen-list-reordering').on('click', function(e){
        e.preventDefault();
        $('.gen-icon-dragg').addClass('active')
        $('.gen-list-reordering__cancel').show()
        
        // $(this).find('span').text('Guardar')

        if($(this).attr('data-handle') == "false"){
            localStorage.removeItem('localStorage-genicons')
            $('.gen-icon-list').css('opacity', .5)
            $(this).find('span').text('Guardar')
            $(this).removeClass('btn-light')
            $(this).addClass('btn-primary')
            $(this).attr('data-handle', true)
            new Sortable(document.getElementById('gen-icon-list'), {
                // options here
                group: "localStorage-genicons",
                store: {
                    /**
                     * Get the order of elements. Called once during initialization.
                     * @param   {Sortable}  sortable
                     * @returns {Array}
                     */
                    get: function (sortable) {
                        var order = localStorage.getItem(sortable.options.group.name);
                        return order ? order.split('|') : [];
                    },
            
                    /**
                     * Save the order of elements. Called onEnd (when the item is dropped).
                     * @param {Sortable}  sortable
                     */
                    set: function (sortable) {
                        var order = sortable.toArray();
                        localStorage.setItem(sortable.options.group.name, order.join('|'));
                    }
                },
                sort: true,
                animation: 200,
                handle: '.gen-icon-dragg',
                dataIdAttr: 'data-id',
            });
        } else {
            
            var localItem = localStorage.getItem('localStorage-genicons');
            if(localItem){
                $('.gen-icon-list').css('opacity', 1)
                $(this).find('span').text('Reordenar')
                $(this).removeClass('btn-primary')
                $(this).addClass('btn-light')
                $(this).attr('data-handle', false)
                var localArr = localItem.split("|");
                console.log(localArr)

                var updateList = []
                $(localArr).each(function(index){
                    var oldId = parseInt(this)
                    var currId = parseInt(index + 1)

                    updateList.push({
                        'oldId': oldId,
                        'currId': currId
                    })

                })

                console.log(updateList)
            } else {
                alert('Ho haz realizado cambios')
                return false
            }
        
            
            
        }


        $('.gen-list-reordering__cancel').on('click', function(e){
            e.preventDefault()
            $('.gen-icon-list').css('opacity', 1)
            $('.gen-list-reordering').find('span').text('Reordenar')
            $('.gen-list-reordering').removeClass('btn-primary')
            $('.gen-list-reordering').addClass('btn-light')
            $('.gen-list-reordering').attr('data-handle', false)
            $(this).hide()
        })

        
        
        

        
    })

    
});