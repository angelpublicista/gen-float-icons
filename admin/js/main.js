jQuery(function ($) {
    // console.log(ajaxRequest)
    $('.color-field').wpColorPicker();
	$(document).on('click', function(e){
        const element = e.target
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
});