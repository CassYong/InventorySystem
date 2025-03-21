<?php
$page_title = 'All Customer';
require_once('includes/load.php');
page_require_level(3);

$customers = find_all_customers();
error_log('Fetched Customers: ' . print_r($customers, true)); // Debugging line
?>

<?php include_once('layouts/header.php'); ?>
<div class="row">
  <div class="col-md-12">
    <?php echo display_msg($msg); ?>
  </div>
  <div class="col-md-12">
    <div class="panel panel-default">
      <div class="panel-heading clearfix">
        <div class="pull-right">
          <a href="add_customer.php" class="btn btn-primary">Add New</a>
        </div>
      </div>
      <div class="panel-body">
        <table class="table table-bordered">
          <thead>
            <tr>
              <th class="text-center" style="width: 50px;">#</th>
              <th> Customer Name </th>
              <th> Email </th>
              <th> Contact Information </th>
              <th class="text-center" style="width: 10%;"> Loyalty Points </th>
              <th class="text-center" style="width: 15%;"> Last Update </th>
              <th class="text-center" style="width: 100px;"> Actions </th>
            </tr>
          </thead>
          <tbody>
            <?php foreach ($customers as $customer): ?>
            <tr>
              <td class="text-center"><?php echo count_id(); ?></td>
              <td><?php echo remove_junk($customer['name'] ?? 'N/A'); ?></td>
              <td><?php echo remove_junk($customer['email'] ?? 'N/A'); ?></td>
              <td><?php echo remove_junk($customer['contactInfo'] ?? 'N/A'); ?></td>
              <td class="text-center"><?php echo remove_junk($customer['loyaltyPoints'] ?? 'N/A'); ?></td>
              <td class="text-center"><?php echo remove_junk($customer['last_update'] ?? 'N/A'); ?></td>
              <td class="text-center">
                <div class="btn-group">
                  <a href="edit_customer.php?id=<?php echo (int)$customer['id']; ?>" class="btn btn-info btn-xs" title="Edit" data-toggle="tooltip">
                    <span class="glyphicon glyphicon-edit"></span>
                  </a>
                  <a href="delete_customer.php?id=<?php echo (int)$customer['id']; ?>" class="btn btn-danger btn-xs" title="Delete" data-toggle="tooltip">
                    <span class="glyphicon glyphicon-trash"></span>
                  </a>
                </div>
              </td>
            </tr>
            <?php endforeach; ?>
          </tbody>
        </table>
      </div>
    </div>
  </div>
</div>
<?php include_once('layouts/footer.php'); ?>
