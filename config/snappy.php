<?php
// 'binary'  => base_path('vendor/h4cc/wkhtmltopdf-i386/bin/wkhtmltopdf-i386')
// palit mo to dun sa
return array(


   'pdf' => array(
       'enabled' => true,
       'binary'  => '/usr/local/bin/wkhtmltopdf-amd64',
       'timeout' => false,
       'options' => array(),
       'env'     => array(),
   ),
   'image' => array(
       'enabled' => true,
       'binary'  => '/usr/local/bin/wkhtmltopdf-amd64',
       'timeout' => false,
       'options' => array(),
       'env'     => array(),
   ),


);
