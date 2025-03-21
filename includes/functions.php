<?php
 $errors = array();

 /*--------------------------------------------------------------*/
 /* Function for Remove escapes special
 /* characters in a string for use in an SQL statement
 /*--------------------------------------------------------------*/
function real_escape($str){
  global $con;
  $escape = mysqli_real_escape_string($con,$str);
  return $escape;
}
/*--------------------------------------------------------------*/
/* Function for Remove html characters
/*--------------------------------------------------------------*/
function remove_junk($str){
  $str = nl2br($str);
  $str = htmlspecialchars(strip_tags($str, ENT_QUOTES));
  return $str;
}
/*--------------------------------------------------------------*/
/* Function for Uppercase first character
/*--------------------------------------------------------------*/
function first_character($str){
  $val = str_replace('-'," ",$str);
  $val = ucfirst($val);
  return $val;
}
/*--------------------------------------------------------------*/
/* Function for Checking input fields not empty
/*--------------------------------------------------------------*/
function validate_fields($var){
  global $errors;
  foreach ($var as $field) {
    $val = remove_junk($_POST[$field]);
    if(isset($val) && $val==''){
      $errors = $field ." can't be blank.";
      return $errors;
    }
  }
}
/*--------------------------------------------------------------*/
/* Function for Display Session Message
   Ex echo displayt_msg($message);
/*--------------------------------------------------------------*/
function display_msg($msg =''){
   $output = array();
   if(!empty($msg)) {
      foreach ($msg as $key => $value) {
         $output  = "<div class=\"alert alert-{$key}\">";
         $output .= "<a href=\"#\" class=\"close\" data-dismiss=\"alert\">&times;</a>";
         $output .= remove_junk(first_character($value));
         $output .= "</div>";
      }
      return $output;
   } else {
     return "" ;
   }
}
/*--------------------------------------------------------------*/
/* Function for redirect
/*--------------------------------------------------------------*/
function redirect($url, $permanent = false)
{
    if (headers_sent() === false)
    {
      header('Location: ' . $url, true, ($permanent === true) ? 301 : 302);
    }

    exit();
}
/*--------------------------------------------------------------*/
/* Function for find out total saleing price, buying price and profit
/*--------------------------------------------------------------*/
function total_price($totals){
  $sum = 0;
  $sub = 0;
  foreach($totals as $total ){
    $sum += isset($total['total_saleing_price']) ? $total['total_saleing_price'] : 0;
    $sub += isset($total['total_buying_price']) ? $total['total_buying_price'] : 0;
  }
  $profit = $sum - $sub; // Calculate profit after the loop
  return array($sum, $profit);
}

/*--------------------------------------------------------------*/
/* Function for Readable date time
/*--------------------------------------------------------------*/
function read_date($str){
     if($str)
      return date('F j, Y, g:i:s a', strtotime($str));
     else
      return null;
  }
/*--------------------------------------------------------------*/
/* Function for  Readable Make date time
/*--------------------------------------------------------------*/
function make_date(){
  return strftime("%Y-%m-%d %H:%M:%S", time());
}
/*--------------------------------------------------------------*/
/* Function for  Readable date time
/*--------------------------------------------------------------*/
function count_id(){
  static $count = 1;
  return $count++;
}
/*--------------------------------------------------------------*/
/* Function for Creting random string
/*--------------------------------------------------------------*/
function randString($length = 5)
{
  $str='';
  $cha = "0123456789abcdefghijklmnopqrstuvwxyz";

  for($x=0; $x<$length; $x++)
   $str .= $cha[mt_rand(0,strlen($cha))];
  return $str;
}


function find_sales_items_by_transaction($transaction_id) {
  global $db;
  $sql  = "SELECT si.id, si.transaction_id, si.product_id, si.quantity, si.price, p.name ";
  $sql .= "FROM sales_items si ";
  $sql .= "JOIN products p ON si.product_id = p.id ";
  $sql .= "WHERE si.transaction_id = '{$transaction_id}'";
  return find_by_sql($sql);
}

function find_all_sales_with_customers() {
  global $db;
  $sql  = "SELECT si.id, si.product_id, si.quantity AS qty, si.price, c.customer_name, st.sale_date AS date, p.name AS product_name ";
  $sql .= "FROM sales_items si ";
  $sql .= "JOIN sales_transactions st ON si.transaction_id = st.id ";
  $sql .= "JOIN customers c ON st.customer_id = c.id ";
  $sql .= "JOIN products p ON si.product_id = p.id";
  return find_by_sql($sql);
}

function find_all_products() {
  global $db;
  $sql = "SELECT id, name, quantity, sale_price FROM products ORDER BY name ASC";
  return find_by_sql($sql);
}

function find_all_customers() {
  global $db;
  $sql  = "SELECT id, customer_name AS name, customer_email AS email, customer_phone AS contactInfo, loyalty_points AS loyaltyPoints, last_update";
  $sql .= " FROM customers";
  $sql .= " ORDER BY customer_name ASC";
  $result = find_by_sql($sql);
  error_log('Customers fetched: ' . print_r($result, true)); // Add this line for debugging
  return $result;
}

?>
