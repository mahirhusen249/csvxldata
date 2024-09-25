<?php    
include 'conn.php';
if(isset($_POST['submit'])){    
   $file_name = "c.csv";
  

    $sql="SELECT id,name,email,password FROM `csvex`";   
    $result=mysqli_query($con,$sql);     
   
    if(!$result){    
        die("query failed:" . mysqli_error($con));
    }   

    $data_arr = [];  

    while ($row = mysqli_fetch_assoc($result)) {    
    $sql1="SELECT mobile_no,gender,address,dob,degree FROM `u_details`where u_id=" . $row['id'];    
  

      $result1= mysqli_query($con,$sql1);  
    
      if(!$result1){  
        die("query failed:");
      }     
    //  $data1=['mobile_no'=>'','gender'=>'','address'=>'','dob'=>'','degree'=>''];    
   

     if (mysqli_num_rows($result1) > 0) {   
        $data1 = mysqli_fetch_assoc($result1);    
     }
 $sql2="SELECT sclass,s_rol_no,s_subject,college_name from studenttbl where s_id=" . $row['id'];  
        $result2=mysqli_query($con,$sql2);   
        if(!$result2){    
            die("query failed:");
        }   
        if(mysqli_num_rows($result2)>0){   
            $std=mysqli_fetch_assoc($result2);
        }   
 $sql3="SELECT c_name,emp_salary,emp_desination from emptbl where emp_id= ".$row['id'];   
 $result3=mysqli_query($con,$sql3);   
 if(!$result3){   
    die("query failed:");  

 }    
 if(mysqli_num_rows($result3)>0){   
    $emp=mysqli_fetch_assoc($result3);
 }      
  $sql4="SELECT product_name,c_price,p_quantity from customer where p_id=".$row['id'];   
  $result4=mysqli_query($con,$sql4);   
  if(!$result4){    
    die("query failed:");
  }   
  if(mysqli_num_rows($result4)>0){  
    $pro=mysqli_fetch_assoc($result4); 

  }
        $data_arr[] = array_merge($row,$data1,$std,$emp,$pro);
    
} 
 
    if (!empty($data_arr)) {
        header('Content-Type: text/csv');
        header('Content-Disposition: attachment; filename="' . $file_name . '"');
        $output = fopen('php://output', 'w');

         

        fputcsv($output, array('id', 'name', 'email', 'password', 'mobile_no',  
        'gender','address','dob','degree','sclass','s_rol_no','s_subject','college_name','c_name','emp_salary','emp_desination','product_name','c_price','p_quantity')); 
          
         foreach ($data_arr as $data) {
             fputcsv($output, $data);
         } 
         fclose($output);
         exit();
     } else {
         echo "No records found.";
     }

}   
?>




<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title> csvxldata</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-QWTKZyjpPEjISv5WaRU9OFeRpok6YctnYmDr5pNlyT2bRjXh0JMhjY6hW+ALEwIH"
        crossorigin="anonymous">
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js" integrity="sha384-YvpcrYf0tY3lHB60NNkmXc5s9fDVZLESaAA55NDzOxhy9GkcIdslK1eN7N6jIeHz"
        crossorigin="anonymous"></script>
</head>

<body>
    <form action="" method="post">
        <div class="container">
            <div class="row justify-content-center mt-5">
                <div class="col-md-3">
                <button type="submit" name="submit" class="btn btn-primary">Export</button>
                </div>
           
            </div>
        </div>
        
    </form>
</body>

</html>