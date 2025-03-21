<?php
$page_title = 'Supplier Report';
require_once('includes/load.php');
page_require_level(2);

$suppliers = find_all('suppliers');
?>

<?php include_once('layouts/header.php'); ?>

<!doctype html>
<html lang="en-US">
<head>
  <meta http-equiv="Content-Type" content="text/html; charset=utf-8">
  <title>Supplier Report</title>
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
          <span>Supplier Report</span>
        </strong>
      </div>
      <div class="panel-body">
        <table class="table table-custom">
          <thead>
            <tr>
              <th>ID</th>
              <th>Supplier Name</th>
              <th>Phone Number</th>
              <th>Email</th>
              <th>Address</th>
            </tr>
          </thead>
          <tbody>
            <?php foreach ($suppliers as $supplier): ?>
              <tr>
                <td><?php echo remove_junk($supplier['supplier_id']); ?></td>
                <td><?php echo remove_junk($supplier['supplier_name']); ?></td>
                <td><?php echo remove_junk($supplier['phone_number']); ?></td>
                <td><?php echo remove_junk($supplier['email']); ?></td>
                <td><?php echo remove_junk($supplier['address']); ?></td>
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
