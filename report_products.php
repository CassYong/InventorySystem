<?php
$page_title = 'Product Report';
require_once('includes/load.php');
page_require_level(2);

$products = find_all('products');
?>

<?php include_once('layouts/header.php'); ?>

<!doctype html>
<html lang="en-US">
<head>
  <meta http-equiv="Content-Type" content="text/html; charset=utf-8">
  <title>Product Report</title>
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

    .table-custom .text-right {
      text-align: right;
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
          <span>Products List</span>
        </strong>
      </div>
      <div class="panel-body">
        <table class="table table-custom">
          <thead>
            <tr>
              <th>ID</th>
              <th>Product Name</th>
              <th>Category</th>
              <th class="text-right">Purchase Price</th>
              <th class="text-right">Sale Price</th>
            </tr>
          </thead>
          <tbody>
            <?php foreach ($products as $product): ?>
              <tr>
                <td><?php echo remove_junk($product['id']); ?></td>
                <td><?php echo remove_junk($product['name']); ?></td>
                <td><?php echo remove_junk(find_by_id('categories', $product['categorie_id'], 'id')['name']); ?></td>
                <td class="text-right"><?php echo remove_junk($product['buy_price']); ?></td>
                <td class="text-right"><?php echo remove_junk($product['sale_price']); ?></td>
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
