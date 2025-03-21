<?php
$page_title = 'Purchase Report';
require_once('includes/load.php');
page_require_level(2);

$purchases = find_all('purchases');
?>

<?php include_once('layouts/header.php'); ?>

<!doctype html>
<html lang="en-US">
<head>
  <meta http-equiv="Content-Type" content="text/html; charset=utf-8">
  <title>Purchase Report</title>
  <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.4/css/bootstrap.min.css"/>
  <style>
    .table-custom {
      width: 100%;
      margin-bottom: 1rem;
      background-color: transparent;
      border-collapse: collapse;
    }

    .table-custom th, .table-custom td {
      padding: 0.75rem;
      vertical-align: top;
    }

    .table-custom thead th {
      vertical-align: bottom;
      border-bottom: 2px solid #000; /* Black border */
    }

    .table-custom tbody tr td {
      border-top: 1px solid #dee2e6;
    }
  </style>
</head>
<body>

<div class="row">
  <div class="col-md-12">
    <?php echo display_msg($msg); ?>
  </div>
</div>

<div class="row">
  <div class="col-md-12">
    <div class="panel panel-default">
      <div class="panel-heading">
        <strong>
          <span class="glyphicon glyphicon-th"></span>
          <span>Purchases List</span>
        </strong>
      </div>
      <div class="panel-body">
        <table class="table table-custom">
          <thead>
            <tr>
              <th>Date</th>
              <th>Product</th>
              <th>Supplier</th>
              <th>Quantity</th>
              <th>Price</th>
              <th>Total Amount</th>
            </tr>
          </thead>
          <tbody>
            <?php foreach ($purchases as $purchase): ?>
              <tr>
                <td><?php echo remove_junk($purchase['date']); ?></td>
                <td><?php echo remove_junk(find_by_id('products', $purchase['product_id'], 'id')['name']); ?></td>
                <td><?php echo remove_junk(find_by_id('suppliers', $purchase['supplier_id'], 'supplier_id')['supplier_name']); ?></td>
                <td><?php echo remove_junk($purchase['quantity']); ?></td>
                <td><?php echo remove_junk(find_by_id('products', $purchase['product_id'], 'id')['buy_price']); ?></td>
                <td><?php echo remove_junk($purchase['total_amount']); ?></td>
              </tr>
            <?php endforeach; ?>
          </tbody>
        </table>
      </div>
    </div>
  </div>
</div>

<?php include_once('layouts/footer.php'); ?>

</body>
</html>
