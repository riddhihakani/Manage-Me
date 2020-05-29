<?php include('includes/header.php'); ?>


<?php

//Include functions
include('admin/includes/functions.php');

//check to see if user if logged in else redirect to index page 


?>

 
<?php

//require or include your database connection file
//require database class files
require('admin/includes/pdocon.php');
    
//instatiating our database objects
$db = new Pdocon;

    //Collect and process Data on login submission
if(isset($_POST['submit_login'])){
    
    $raw_username       =   cleandata($_POST['username']);
    
    $raw_password       =   cleandata($_POST['password']);
    
    
    $c_username         =   valemail($raw_username);            
    
    $hashed_password    =   hashpassword($raw_password);
      
    
    $db->query('SELECT * FROM admin WHERE email=:email AND password=:password');
    
    $db->bindValue(':email', $c_username, PDO::PARAM_STR);
    $db->bindValue(':password',$hashed_password, PDO::PARAM_STR);
    
    $row = $db->fetchSingle();
    
    
    if($row){
        
        $d_image        =   $row['image'];
        
        $d_name         =   $row['fullname'];
        
        $s_image        =   "<img src='uploaded_image/$d_image' class='profile_image' />"; 
        
        $_SESSION['user_data'] = array(
        
        
        'fullname'      =>   $row['fullname'],
        'id'            =>   $row['id'],
        'email'         =>   $row['email'],
        'image'         =>   $s_image

        );
        
        $_SESSION['user_is_logged_in']  =  true;
        
        redirect('admin/my_admin.php');
        
        
        keepmsg('<div class="alert alert-success text-center">
                      <a href="#" class="close" data-dismiss="alert" aria-label="close">&times;</a>
                      <strong>Welcome </strong>' . $d_name . ' You are logged in as Admin 
                </div>');
        
        
        
        
    }else{
        
         echo '<div class="alert alert-danger text-center">
              <a href="#" class="close" data-dismiss="alert" aria-label="close">&times;</a>
              <strong>Sorry!</strong> User does not exist. Register or Try Again
            </div>';

    }    
    
    
    
    
}
 

?>
  
  <div class="row">
      <div class="col-md-4 col-md-offset-4">
          <p class=""><a class="pull-right" href="admin/register_admin.php"> Register</a></p><br>
      </div>
      <div class="col-md-4 col-md-offset-4">
        <form class="form-horizontal" role="form" method="post" action="index.php">
          <div class="form-group">
            <label class="control-label col-sm-2" for="email"></label>
            <div class="col-sm-10">
              <input type="email" name="username" class="form-control" id="email" placeholder="Enter Email" required>
            </div>
          </div>
          <div class="form-group">
            <label class="control-label col-sm-2" for="pwd"></label>
            <div class="col-sm-10"> 
              <input type="password" name="password" class="form-control" id="pwd" placeholder="Enter Password" required>
            </div>
          </div>

          <div class="form-group"> 
            <div class="col-sm-offset-2 col-sm-10 text-center">
              <button type="submit" class="btn btn-primary text-center" name="submit_login">Login</button>
            </div>
          </div>
        </form>
          
  </div>
</div>
  
  
<?php include('includes/footer.php'); ?>