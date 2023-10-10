<?php
 $conn = mysqli_connect("localhost", "root","", "medi_db");
  
 // Check connection
 if($conn === false){
     die("ERROR: Could not connect. "
         . mysqli_connect_error());
 }
   
 if($_POST['submit'])  
{  $a=$_POST['client_id'];  
    $b=$_POST['timer'];
echo $s="INSERT INTO medi_timer VALUES(NULL,'$a','$b','".$_POST['created_at']."','".$_POST['updated_at']."')";  
echo "Your Data Inserted";  
mysqli_query($conn, $s);  
} else{
    echo("Error description: " . mysqli_error($conn));
}
  
 // Close connection
 mysqli_close($conn);
 ?>
