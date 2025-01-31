<?php
       
       function lang($word){

           static $lang = array(

            //   All Words in Navbar
             
             'HOME_PAGE' => 'Admin',
             'CATEGORIES' => 'Categories',
             'ITEMS' => ' Items ',
             'MEMBERS' => 'Members',
             'COMMENTS' => 'Comments',
             'STATISTICS' => 'Statistics',
             'LOGS' => 'Logs',
             'COMMENTS' => 'Comments',
             
             

            //  All Words in Settings

           );

           return $lang[$word];


       }

?>