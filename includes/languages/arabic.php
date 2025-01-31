<?php
       
       function lang($word){

           static $lang = array(

            //   All Words in HomePage
             
             'MESSAGE' => 'Welcome in arabic',
             'ADMIN' => 'Arabic Adminstrator '

            //  All Words in Settings

           );

           return $lang[$word];


       }

?>