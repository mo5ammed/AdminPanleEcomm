<?php

    ob_start();

    session_start();

    if(isset($_SESSION['Username'])){
         

        include 'init.php';
       
        $do = isset($_GET['do']) ? $_GET['do'] : 'Manage' ;


        if($do == 'Manage') { 
          
          $query = '';


          // if recuset = page and page = pending
          if(isset($_GET['page']) && $_GET['page'] == 'Pending'){

          // VIEW members no activate
            $query = 'AND RegStatus = 0';
          }
          // view all members
          $stmt = $con->prepare("SELECT * FROM users WHERE GroupID != 1 $query");

          $stmt->execute();

          $rows = $stmt->fetchAll();
          
          
          
          ?>


          <style>
            .main-table td{
              background-color:#FFF;
            }
            .main-table tr:first-child td{
              background-color:#333;
              color: #FFF;
            }

            h1{
              font-size: 55px;
              margin: 40px 0;
              font-weight:bold;
              color:#666;            
            }
          </style>
           
           <h1 class="text-center h">Manage Members</h1>
            <div class="container">
              <div class="table-responsive">
                <style>.main-table tr:first-child td { background-color: #333 ; color: #FFF ;}</style>
                <table class="main-table text-center table table-bordered">
            <tr>
              <td>#ID</td>
              <td>Username</td>
              <td>Email</td>
              <td>Full Name</td>
              <td>Registerd Data</td>
              <td>Control</td>
            </tr>


          <?php  
          
          foreach($rows as $row){

            echo "<tr>" ;
                echo "<td>" . $row['UserID'] ."</td>";
                echo "<td>" . $row['Username'] ."</td>";
                echo "<td>" . $row['Email'] ."</td>";
                echo "<td>" . $row['FullName'] ."</td>";
                echo "<td>" . $row['Date']."</td>";
                echo "<td>
                <a href='members.php?do=Edit&userid=". $row['UserID']."' class='btn btn-success confirm'><i class='fa fa-edit'></i>  Edit</a>
                <a href='members.php?do=Delete&userid=". $row['UserID']."' class='btn btn-danger confirm'><i class='fa fa-close'></i> Delete</a>";
              
                    if($row['RegStatus'] ==  0){

                      echo "<a href='members.php?do=Activate&userid=". $row['UserID']."'class='btn btn-info activate'><i class='fa fa-close'></i> Activate</a>";               
                      echo" <style>.activate{ margin-left:5px;}</style>";

                    }
                echo "</td>";
            echo "</tr>";
          }
          
            
          ?>
       
           
            </table>
            </div>
            <a href="members.php?do=Add" style="background-color: #04569f;" class="btn btn-primary"> <i class="fa fa-plus"></i>Add New Members</a>
            </div>


<!-- /////////////////////////////////////////////////////////////////////////////////////////////////////////////////////// -->


    
     <?php   }elseif($do == 'Add'){ ?>

          <h1 class="text-center">Add New Member</h1>
          <div class="container">
             
     <form class="form-horizontal" action="?do=Insert" method="POST">
       <input type="hidden" name="userid" value="<?php echo $userid ?>">
         <div class="form-group form-group-lg">
           <label class="col-sm-2 control-label">Username</label>
           <div class="col-sm-10 col-md-4">
               <input type="text" name="username" class="form-control" autocomplete="off" required="required" placeholder=""/>
           </div>
         </div>


         <div class="form-group form-group-lg">
           <label class="col-sm-2 control-label">Password</label>
           <div class="col-sm-10 col-md-4">
               <input type="password" name="password" class="form-control"  autocomplete="new-password" required="required" placeholder="" />              
           </div>
         </div>

         <div class="form-group form-group-lg">
           <label class="col-sm-2 control-label">Email</label>
           <div class="col-sm-10 col-md-4">
               <input type="email" name="email"  class="form-control" required="required" placeholder=""/>
           </div>
         </div>

         
         <div class="form-group form-group-lg">
           <label class="col-sm-2 control-label">Full Name</label>
           <div class="col-sm-10 col-md-4">
               <input type="text" name="full"  class="form-control" required="required" placeholder="" />
           </div>
         </div>

         <div class="form-group form-group-lg">
           <div class="col-sm-offset-2 col-sm-10">
               <input type="submit" value="Add" class="btn btn-primary" />
           </div>
         </div>


     </form>

     </div>
  

     <?php 


/////////////////////////////////////////////////////////////////////////////////////////////////


    } elseif($do == 'Insert' ){

     
       
       if($_SERVER['REQUEST_METHOD'] == 'POST' ){

        echo '<h1 class="text-center">Update Member</h1>';
        echo '<div class="container">';

         $user   = $_POST['username'];
         $pass   = $_POST['password'];
         $email  = $_POST['email'];
         $name   = $_POST['full'];

        
         $hashPass = sha1($_POST['password']);
       

         $formErrors = array();

         if(strlen($user) < 4){

           $formErrors[] = 'Username Cant Be Less Than <strong>4 Characters</strong>';
           
         } if(strlen($user) > 20 ){

         $formErrors[] = 'Username Cant Be More Than <strong>20 Characters</strong>';
         
         }if(empty($user)){

            $formErrors[] = 'Username Cant Be <strong>Empty</strong>';

         }if(empty($pass)){

          $formErrors[] = 'Password Cant Be <strong>Empty</strong>';

       } if(empty($name)){

           $formErrors[] = 'Full Name Cant Be <strong>Empty</strong>';
           
         }if(empty($email)){

           $formErrors[] = 'Email Cant Be <strong>Empty</strong>';

         }

         foreach($formErrors as $error){
           echo  '<div class="alert alert-danger">'. $error .'</div>'. '<br/>';
         }
     
         if (empty($formErrors)){

           $check = checkItem("Username" , "users" , $user);

           if($check == 1){
               
              $theMsg = '<div class="alert alert-danger">Sorry This User Is Exist</div>';
              redirectHome($theMsg,'back');

           }else{

           $stmt = $con->prepare("INSERT INTO users(Username, Password, Email, FullName , RegStatus , Date)
                                              VALUES(:zuser, :zpass, :zmail, :zname,1,now())");
           $stmt->execute(array( 'zuser' => $user , 
                                 'zpass' => $hashPass , 
                                 'zmail' => $email ,
                                 'zname' => $name ,                                
                                ));  
 
           $theMsg = "<div class='alert alert-success'>" . $stmt->rowCount() . 'Record Updated</div>';
           redirectHome($theMsg , 'back');
         
            }

         }


       }else {

          echo "<div class='container'>";

          $theMsg = '<div class="alert alert-danger">Sorry You Cant Browse This Page Directly</div>';

          redirectHome($theMsg , 'back');

          echo "</div>";
       }

       echo '</div>';




///////////////////////////////////////////////////////////////////////////////////////////////////////


    
    }elseif($do == 'Edit') {
          
          $userid = isset($_GET['userid']) && is_numeric($_GET['userid']) ? intval($_GET['userid']) : 0 ;
          $stmt = $con->prepare("SELECT * FROM users WHERE  UserID = ? LIMIT 1");
          $stmt->execute(array($userid));
          $row = $stmt->fetch();
          $count = $stmt->rowCount();

        

          if($count > 0) { ?>

          <h1 class="text-center">Edit Member</h1>
           <div class="container">
              
      <form class="form-horizontal" action="?do=Update" method="POST">
        <input type="hidden" name="userid" value="<?php echo $userid ?>">
          <div class="form-group form-group-lg">
            <label class="col-sm-2 control-label">Username</label>
            <div class="col-sm-10 col-md-4">
                <input type="text" name="username" value="<?php echo $row['Username'] ?>" class="form-control" autocomplete="off" required="required"/>
            </div>
          </div>


          <div class="form-group form-group-lg">
            <label class="col-sm-2 control-label">Password</label>
            <div class="col-sm-10 col-md-4">
                <input type="hidden" name="oldpassword" value="<?php echo $row['Password'] ?>" />
                <input type="password" name="newpassword" class="form-control"  autocomplete="new-password"/>
            </div>
          </div>

          <div class="form-group form-group-lg">
            <label class="col-sm-2 control-label">Email</label>
            <div class="col-sm-10 col-md-4">
                <input type="email" name="email" value="<?php echo $row['Email']?>" class="form-control" required="required" />
            </div>
          </div>

          
          <div class="form-group form-group-lg">
            <label class="col-sm-2 control-label">Full Name</label>
            <div class="col-sm-10 col-md-4">
                <input type="text" name="full" value="<?php echo $row['FullName']?>" class="form-control" required="required"/>
            </div>
          </div>

          <div class="form-group form-group-lg">
            <div class="col-sm-offset-2 col-sm-10">
                <input type="submit" value="Save" class="btn btn-primary" />
            </div>
          </div>


      </form>

      </div>
   
        
 <?php 

      // if There's No Such ID Show Message

     } else{

           echo "<div class='container'>";

           $theMsg =  '<div class="alert alert-danger">Theres No Such ID</div>';

           redirectHome($theMsg);

           echo "</div>";

        }





/////////////////////////////////////////////////////////////////////////////////////////////////////////



      }elseif($do == 'Update'){

       echo '<h1 class="text-center">Update Member</h1>';
       echo '<div class="container">';
        
        if($_SERVER['REQUEST_METHOD'] == 'POST' ){

          $id = $_POST['userid'];
          $user = $_POST['username'];
          $email = $_POST['email'];
          $name = $_POST['full'];

         
          $pass = empty($_POST['newpassword']) ? $_POST['oldpassword'] : sha1($_POST['newpassword']);
        

          $formErrors = array();

          if(strlen($user) < 4){

            $formErrors[] = 'Username Cant Be Less Than <strong>4 Characters</strong>';
            
          } if(strlen($user) > 20){

          $formErrors[] = 'Username Cant Be More Than <strong>20 Characters</strong>';
          
          }if(empty($user)){

             $formErrors[] = 'Username Cant Be <strong>Empty</strong>';

          }if(empty($name)){

            $formErrors[] = 'Full Name Cant Be <strong>Empty</strong>';
            
          }if(empty($email)){

            $formErrors[] = 'Email Cant Be <strong>Empty</strong>';

          }

          foreach($formErrors as $error){
            echo  '<div class="alert alert-danger">'. $error .'</div>'. '<br/>';
          }
      
          if (empty($formErrors)){

            $stmt = $con->prepare("UPDATE users SET Username = ? , Email = ? , FullName = ? , Password = ? WHERE UserID =? ");
            $stmt->execute(array($user , $email , $name ,$pass , $id));  
  
            
            $theMsg =  "<div class='alert alert-success'>" . $stmt->rowCount() . 'Record Updated</div>';
            // ['back'] = no redirect homepage
            redirectHome($theMsg , 'back');
  
          }


        }else {

           $theMsg = '<div class="alert alert-danger">Sorry You Cant Browse This Page Directly</div>';
           //redirect HomePage
           redirectHome($theMsg);

        }
           echo "</div>";



/////////////////////////////////////////////////////////////////////////////////////////////



      } elseif($do == 'Delete'){
        $userid = isset($_GET['userid']) && is_numeric($_GET['userid']) ? intval($_GET['userid']) : 0 ;


       $check = checkItem('userid', 'users' , $userid);

        echo "<h1 class='text-center'>Delet Member</h1>";
        echo "<div class='container'>";

        if( $check > 0) {

          

            $stmt = $con->prepare("DELETE FROM users WHERE UserID = :zuser");
            $stmt->bindParam(":zuser" , $userid);
            $stmt->execute();
           
            $theMsg = "<div class='alert alert-success'>" . $stmt->rowCount() . 'Record Deleted</div>';

             redirectHome($theMsg);
            
          }else{

            $theMsg = '<div class="alert alert-danger">This ID is Not Exist</div>';
            redirectHome($theMsg);
          }

          echo '</div>' ;

    }elseif( $do =='Activate'){

      $userid = isset($_GET['userid']) && is_numeric($_GET['userid']) ? intval($_GET['userid']) : 0 ;


      $check = checkItem('userid', 'users' , $userid);

       echo "<h1 class='text-center'>Delet Member</h1>";
       echo "<div class='container'>";

       if( $check > 0) {

         

           $stmt = $con->prepare("UPDATE users SET RegStatus = 1 WHERE UserID = ?");
           
           $stmt->execute(array($userid));
          
           $theMsg = "<div class='alert alert-success'>" . $stmt->rowCount() . 'Record Update</div>';

            redirectHome($theMsg);
           
         }else{

           $theMsg = '<div class="alert alert-danger">This ID is Not Exist</div>';
           redirectHome($theMsg);
         }

         echo '</div>' ;

    }

        include 'includes/templates/footer.php';

    }else {
        header('Location: index.php');
        exit();
    }


    

     ob_end_flush();
?>