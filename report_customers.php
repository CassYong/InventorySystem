<?php
$page_title = 'Customer Report';
require_once('includes/load.php');
page_require_level(2);

$customers = find_all('customers');
?>

<?php include_once('layouts/header.php'); ?>

<!doctype html>
<html lang="en-US">
<head>
  <meta http-equiv="Content-Type" content="text/html; charset=utf-8">
  <title>Customer Report</title>
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
          <span>Customers List</span>
        </strong>
      </div>
      <div class="panel-body">
        <table class="table table-custom">
          <thead>
            <tr>
              <th>ID</th>
              <th>Customer Name</th>
              <th>Phone Number</th>
              <th>Email</th>
              <th>Loyalty Points</th>
            </tr>
          </thead>
          <tbody>
            <?php foreach ($customers as $customer): ?>
              <tr>
                <td><?php echo remove_junk($customer['id']); ?></td>
                <td><?php echo remove_junk($customer['customer_name']); ?></td>
                <td><?php echo remove_junk($customer['customer_phone']); ?></td>
                <td><?php echo remove_junk($customer['customer_email']); ?></td>
                <td><?php echo remove_junk($customer['loyalty_points']); ?></td>
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
