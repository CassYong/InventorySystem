<?php
  require_once('includes/load.php');
  // Checkin What level user has permission to view this page
  page_require_level(3);

  $sale_id = (int)$_GET['id'];
  $sale = find_by_id('sales_items', $sale_id);

  if ($sale) {
      $transaction_id = $sale['transaction_id'];
      $db->query("DELETE FROM sales_items WHERE transaction_id = '{$transaction_id}'");
      $db->query("DELETE FROM sales_transactions WHERE id = '{$transaction_id}'");
      $session->msg("s", "Sale deleted.");
  } else {
      $session->msg("d", "Sale not found.");
  }
  redirect('sales.php');
?>
