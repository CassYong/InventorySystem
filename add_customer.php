<?php
$page_title = 'Add Customer';
require_once('includes/load.php');
// Check what level user has permission to view this page
page_require_level(3);

if (isset($_POST['add_customer'])) {
    $req_fields = array('customer-name', 'customer-phone');
    validate_fields($req_fields);

    if (empty($errors)) {
        $name = remove_junk($db->escape($_POST['customer-name']));
        $email = isset($_POST['customer-email']) ? remove_junk($db->escape($_POST['customer-email'])) : '';
        $phone = remove_junk($db->escape($_POST['customer-phone']));

        $query  = "INSERT INTO customers (";
        $query .= "customer_name, customer_email, customer_phone";
        $query .= ") VALUES (";
        $query .= "'{$name}', '{$email}', '{$phone}'";
        $query .= ")";
        if ($db->query($query)) {
            $session->msg('s', "Customer added successfully!");
            redirect('add_customer.php', false);
        } else {
            $session->msg('d', 'Sorry, failed to add customer!');
            redirect('add_customer.php', false);
        }
    } else {
        $session->msg("d", $errors);
        redirect('add_customer.php', false);
    }
}
?>

<?php include_once('layouts/header.php'); ?>
<div class="row">
    <div class="col-md-12">
        <?php echo display_msg($msg); ?> <!-- Display messages (if any) -->
    </div>
</div>
<div class="row">
    <div class="col-md-8">
        <div class="panel panel-default">
            <div class="panel-heading">
                <strong>
                    <span class="glyphicon glyphicon-user"></span>
                    <span>Add New Customer</span>
                </strong>
            </div>
            <div class="panel-body">
                <div class="col-md-12">
                    <form method="post" action="add_customer.php" class="clearfix">
                        <div class="form-group">
                            <div class="input-group">
                                <span class="input-group-addon">
                                    <i class="glyphicon glyphicon-user"></i>
                                </span>
                                <input type="text" class="form-control" name="customer-name" placeholder="Customer Name">
                            </div>
                        </div>
                        <div class="form-group">
                            <div class="input-group">
                                <span class="input-group-addon">
                                    <i class="glyphicon glyphicon-envelope"></i>
                                </span>
                                <input type="email" class="form-control" name="customer-email" placeholder="Email Address">
                            </div>
                        </div>
                        <div class="form-group">
                            <div class="input-group">
                                <span class="input-group-addon">
                                    <i class="glyphicon glyphicon-phone"></i>
                                </span>
                                <input type="tel" class="form-control" name="customer-phone" placeholder="Phone Number">
                            </div>
                        </div>
                        <button type="submit" name="add_customer" class="btn btn-primary">Add Customer</button>
                    </form>
                </div>
            </div>
        </div>
    </div>
</div>
<?php include_once('layouts/footer.php'); ?>
