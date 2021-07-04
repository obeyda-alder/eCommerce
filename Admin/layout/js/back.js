$(function(){
 
    'use strict';

    // toggel-- show Or Hide information 

    $('.toggel-info').on('click', function () {

      $(this).parent().next('.card-body').fadeToggle(400);
      $(this).children('i').toggleClass('fa-minus').toggleClass('fa-plus');
    });

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

    let pass = $('.password');

    $('.show-pass').on('click', function(){

        var newType = (pass.attr('type') === "password")?"text":"password";
        pass.attr('type' , newType);

  
    });

    $('.confirm').on('click' , function () {
 
        return confirm('Are You Sure');
    });

    // Category View Option
     $('.cat h3').on('click', function (){

        $(this).next('.full-view').fadeToggle(200);

     });

     $('.option span').on('click', function () {

        $(this).addClass('active').siblings('span').removeClass('active');

        if($(this).data('view') == 'full'){

            $('.cat .full-view').fadeIn(200);

        }else{

            $('.cat .full-view').fadeOut(200);
        }
     });

});