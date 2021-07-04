<?php

   function lang($phrase) {
       static $lang = array(

        // Navbar Links

        'Navbar_BrandBr'   => 'eCommerce',
        'CATEGORIES'   => 'Categories',
        'ITEMS'        => 'Items',
        'MEMBERS'      => 'Members',
        'COMMENTS'     => 'Comments',
        'STATSTICS'    => 'Statistics',
        'LOGS'         => 'Logs',

        ''    => '',
        ''    => '',
        ''    => '',
        ''    => '',
        ''    => ''

       );

       return $lang[$phrase];
   }