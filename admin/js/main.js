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


        if(element.classList.contains('btnUpdate')){
            const dataId = element.dataset.id

            var formUpdate = $('#form-new-item')

            $('#gen-modal-update').on('shown.bs.modal', function (event) {
                $('#gen-modal-update').find('#title').val('Mi texto')
            })

        }

        
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