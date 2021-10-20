jQuery(function ($) {
	/* Puedes usar $ con seguridad para hacer referencia a jQuery */
    $('.gen-link-toggle').on('click', function(e) {
        e.preventDefault()
        $('.gen-float-icons__item-data').slideToggle('fast', function(){
            if($('.gen-float-icons__item-data').is(':hidden')){
                $('.gen-link-toggle').html('<i class="fas fa-comment-dots"></i>')
            } else {
                $('.gen-link-toggle').html('<i class="fas fa-times"></i>')
            }
        })
    })
});
