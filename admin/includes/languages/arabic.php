<?php

   function lang($phrase){

          static $lang = array(

            'mohammed' => 'welcome',
          );

          return $lang[$phrase];

   }
