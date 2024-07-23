$(document).ready(function(){

    var $container = $('.gallery .box-container');//THIS IS THE NAME OF THE CLASS FOR THE CONTAINER THAT WILL HOLD THE PROJECTS IMAGES
    $container.isotope({
        filter: '*',
        animationOptions: {
            duration: 750,      //TIMING IN MS
            easing: 'linear',   //EASING
            queue: false
        } 
    }); 
 
    $('.gallery .tab-buttons li').click(function(){
        $('.gallery .tab-buttons .active').removeClass('active');
        $(this).addClass('active');
 
        var selector = $(this).attr('data-filter');
        $container.isotope({
            filter: selector,
            animationOptions: {
                duration: 750,     //TIMING IN MS
                easing: 'linear',  //EASING
                queue: false
            }
         });
         return false; 
    }); 
 
    //MAGNIFIC-POPUP
    $(".gallery").magnificPopup({
        
        delegate: ".view",
        type: "image",
        removalDelay: 500, //delay removal by X to allow out-animation
        gallery:{
            enabled: true
        },

    })


});