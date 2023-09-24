<?php

defined('BASEPATH') OR exit('No direct script access allowed');

/*
  | -------------------------------------------------------------------------
  | Hooks
  | -------------------------------------------------------------------------
  | This file lets you define "hooks" to extend CI without hacking the core
  | files.  Please see the user guide for info:
  |
  |	https://codeigniter.com/user_guide/general/hooks.html
  |
 */
$hook['post_controller_constructor'][] = array(
    "class" => "Sch_access",
    "function" => "initialize",
    "filename" => "sch_access.php",
    "filepath" => "hooks"
);

// $hook['post_controller_constructor'][] = array(
//     'class' => 'Sch_access',
//     'function' => 'checkPermission',
//     'filename' => 'sch_access.php',
//     'filepath' => 'hooks'
// );

$hook['post_controller_constructor'][] = array(
    'class' => 'Sch_lang',
    'function' => 'set_lang',
    'filename' => 'sch_lang.php',
    'filepath' => 'hooks'
);
