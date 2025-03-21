<?php
  require_once('includes/load.php');
  page_require_level(2);

  if(isset($_GET['id'])){
    $supplier_id = (int)$_GET['id'];
    $delete_id = delete_by_id('suppliers', $supplier_id, 'supplier_id'); // Updated line
    if($delete_id){
      $session->msg("s", "Supplier deleted.");
      redirect('supplier.php');
    } else {
      $session->msg("d", "Failed to delete supplier.");
      redirect('supplier.php');
    }
  } else {
    $session->msg("d", "Missing supplier ID.");
    redirect('supplier.php');
  }
?>
