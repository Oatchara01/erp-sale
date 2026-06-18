<?php
require ('dbconnect.php');
$output = '';
if(isset($_POST["query"]))
{
 $search = mysqli_real_escape_string($conn, $_POST["query"]);
 $query = "SELECT * FROM tb_customer
WHERE  customer_name  LIKE '%".$search."%' ";}
else
{
 $query = "SELECT * FROM tb_customer";
}
$result = mysqli_query($conn, $query);
if(mysqli_num_rows($result) > 0)
{
 $output .= 'select name="cus"';
 while($row1 = mysqli_fetch_array($result))
 {
  $output .= '
  <tr>
  	<td>'.$row1["customer_name"].'</td>
    <td>'.$row1["address"].'</td>
   </tr>
  ';
 }
 echo $output;
}
else
{
 echo 'Record Not Found';
}
?>