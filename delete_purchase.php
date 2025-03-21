<?php
  require_once('includes/load.php');
  page_require_level(2);

  if (isset($_GET['id'])) {
    $purchase_id = (int)$_GET['id'];
    $delete_id = delete_by_id('purchases', $purchase_id, 'purchase_id'); // Updated line
    if ($delete_id) {
      $session->msg("s", "Purchase deleted.");
      redirect('purchase.php');
    } else {
      $session->msg("d", "Failed to delete purchase.");
      redirect('purchase.php');
    }
  } else {
    $session->msg("d", "Missing purchase ID.");
    redirect('purchase.php');
  }
?>
