<?php


function mailtrap($phpmailer) {
    $phpmailer->isSMTP();
  $phpmailer->Host = 'smtp.mailtrap.io';
  $phpmailer->SMTPAuth = true;
  $phpmailer->Port = 2525;
  $phpmailer->Username = 'fcb99a7598134b';
  $phpmailer->Password = '0f1950f1e41097';
}
 
add_action('phpmailer_init', 'mailtrap');