$(function(){
 
    'use strict';
    
     // where refresh page becauses block insert data Again
     if ( window.history.replaceState ) {
        window.history.replaceState( null, null, window.location.href );
    }

     // Calls the selectBoxIt method on your HTML select box
        $("select").selectBoxIt({

            // Uses the jQuery 'fadeIn' effect when opening the drop down
            showEffect: "fadeIn",

            // Sets the jQuery 'fadeIn' effect speed to 400 milleseconds
            showEffectSpeed: 500,

            // Uses the jQuery 'fadeOut' effect when closing the drop down
            hideEffect: "fadeOut",

            // Sets the jQuery 'fadeOut' effect speed to 400 milleseconds
            hideEffectSpeed: 400,

            autoWidth: false,

        });

    // Hide Placehoder On Form Focus
    $('[placeholder]').focus(function () {
        $(this).attr('data-text' , $(this).attr('placeholder'));
        $(this).attr('placeholder' , '');
    }).blur(function () {
        $(this).attr('placeholder' , $(this).attr('data-text')); 
    });

    // Add Asterisk On Requierd Field
    $('input').each(function () {
        
        if($(this).attr('required') === 'required'){
            $(this).after('<i class="fas fa-asterisk asterisk"></i>');
        }
    });

    // confirm when delete somthing
    $('.confirm').on('click' , function () {
 
        return confirm('Are You Sure');
    });

    // display Forms When You need ~ login Or signup
    $('.login-page h2 span').on('click', function (){

        $(this).addClass('selected').siblings().removeClass('selected');

        $('.login-page form').hide();

        $($(this).data('class')).fadeIn(200);
    });

        // // connection ajax request 
        // $('form').on('click', function(){
        //     $.ajax({
        //         url: 'Admin/connect.php',
        //         type: 'GET',
        //         success: function(data){
        //             console.log(data); //will show George in the console
        //             //otherwise it will show sql_srv errors.
        //         }
        //     });
        // });


        

        // function for change LivePreview By cards in page newAd!!
        function LivePreview(send, target){

            $(send).on('keyup', function (){

                $(target).text($(this).val());
            });
        }

        // call function Live..
        LivePreview('.live-name', '.Live-Preview h5');
        LivePreview('.live-desc', '.Live-Preview p');
        LivePreview('.live-price', '.Live-Preview .price-carde');

        // function for change LivePreview By cards in page newAd!! [but this is tow way]
        //$('.live-name').on('keyup', function (){

        //     $('.Live-Preview h5').text($(this).val());
        // });

        // $('.live-desc').on('keyup', function (){

        //     $('.Live-Preview p').text($(this).val());
        // });

        // $('.live-price').on('keyup', function (){

        //     $('.Live-Preview span').text('$' + $(this).val());
        // }); ]]]]]]]


        // animation to Arrows Icon
        // $('.icon-arrow').hover(function(){

        //     $(this).animate({FontSize: '100px'});

        //     });

        
});