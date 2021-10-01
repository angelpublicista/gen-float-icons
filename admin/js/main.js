jQuery(function ($) {
    // console.log(ajaxRequest)
    $('.color-field').wpColorPicker();


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

    // new Sortable(document.getElementById('gen-ul-list'), {
    //     // options here
    //     group: "localStorage-genicons",
    //     store: {
    //         /**
    //          * Get the order of elements. Called once during initialization.
    //          * @param   {Sortable}  sortable
    //          * @returns {Array}
    //          */
    //         get: function (sortable) {
    //             var order = localStorage.getItem(sortable.options.group.name);
    //             return order ? order.split('|') : [];
    //         },
    
    //         /**
    //          * Save the order of elements. Called onEnd (when the item is dropped).
    //          * @param {Sortable}  sortable
    //          */
    //         set: function (sortable) {
    //             var order = sortable.toArray();
    //             localStorage.setItem(sortable.options.group.name, order.join('|'));
    //         }
    //     },
    //     sort: true,
    //     animation: 200,
    //     handle: '.gen-icon-dragg',
    //     dataIdAttr: 'data-id',
    // });
});