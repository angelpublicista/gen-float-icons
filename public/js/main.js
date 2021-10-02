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

    $('.gen-float-icons__item-data').each(function() {
        var dataCss = jQuery.parseJSON($(this).attr('data-css'));
        $(this).find('.gen-float-icons__list__link').css('background', dataCss.bgColor)
        
        $(this).find('.gen-float-icons__list__link').mouseover( function() {
            $(this).css('background',  dataCss.bgColorHover)
            $(this).css('color',  dataCss.colorIcon)
        })

        $(this).find('.gen-float-icons__list__link').mouseout( function() {
            $(this).css('background',  dataCss.bgColor)
            $(this).css('color',  dataCss.colorIconHover)
        })

    })
    // $('.gen-float-icons__list__item .gen-float-icons__list__link').css('background', dataCss.bgColor)    
});
// const linkFloatIcons = floatIcons.querySelectorAll('.gen-float-icons__list__link');

// for (const item of linkFloatIcons) {
//     item.addEventListener('mouseover', () => {
//         item.style.background = item.dataset.hover
//         item.style.color = item.dataset.iconhover
//     })

//     item.addEventListener('mouseout', () => {
//         item.style.background = item.dataset.normal
//         item.style.color = item.dataset.iconnormal
//     })
// }

// const genButtonToggle = document.querySelector('.gen-item-toggle__button')
// const itemsToggle = document.querySelectorAll('.gen-item')

// genButtonToggle.addEventListener('click', (e) => {
//     e.preventDefault()
//     for (const item of itemsToggle) {
//         item.style.display = "flex"
//     }

// })