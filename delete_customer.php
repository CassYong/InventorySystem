<?php
  require_once('includes/load.php');
  // Check What level user has permission to view this page
  page_require_level(3);

  $customer = find_by_id('customers',(int)$_GET['id']);

  if(!$customer){
    $session->msg("d","Missing Customer id.");
    redirect('customer.php');
  }

  $delete_id = delete_by_id('customers',(int)$customer['id']);

  if($delete_id){
      $session->msg("s","Customer deleted.");
      redirect('customer.php');
  } else {
      $session->msg("d","Customer deletion failed.");
      redirect('customer.php');
  }
?>
