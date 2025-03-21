<?php
  $page_title = 'Reports';
  require_once('includes/load.php');
  page_require_level(2);
?>
<?php include_once('layouts/header.php'); ?>

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
          <span>Reports</span>
        </strong>
      </div>
      <div class="panel-body">
        <ul class="list-group">
          <li class="list-group-item">
            <a href="report_products.php" style="font-size: 1.5em; font-weight: bold;">Product List</a>
          </li>
          <li class="list-group-item">
            <a href="report_suppliers.php" style="font-size: 1.5em; font-weight: bold;">Supplier List</a>
          </li>
          <li class="list-group-item">
            <a href="report_customers.php" style="font-size: 1.5em; font-weight: bold;">Customer List</a>
          </li>
          <li class="list-group-item">
            <a href="report_sales.php" style="font-size: 1.5em; font-weight: bold;">Sales Report</a>
          </li>
          <li class="list-group-item">
            <a href="report_purchases.php" style="font-size: 1.5em; font-weight: bold;">Purchase Report</a>
          </li>
          <li class="list-group-item">
            <a href="report_stock_balance.php" style="font-size: 1.5em; font-weight: bold;">Stock Balance</a>
          </li>
        </ul>
      </div>
    </div>
  </div>
</div>

<?php include_once('layouts/footer.php'); ?>
