


<?php


ob_start();

session_start();

$pageTitle = 'Items';

if (isset($_SESSION['Username'])){
    include 'init.php';
    include 'button.php';

    
    $do = isset($_GET['do']) ? $_GET['do'] : 'Manage' ;

    if($do == 'Manage'){
        echo 'Welcome To Items Page';
    }elseif($do == 'Add'){ ?>
     
     <h1 class="text-center">Add New Item</h1>
     <div class="container">
        <form class="form-horizontal" action="?do=Insert" method="POST">
            <!-- Start Name Field -->
            <!-- <div class="form-group form-group-lg">                
                <label class="col-sm-2 control-lable">Name</label>
                <div class="col-sm-10 col-md-6">
                <input type="text" name="name" class="form-control" required="required" 
                placeholder="Name Of The Item"/>
            </div> -->
          <?php $names = buttons('Name','name'); ?>

           
            <!-- </div> -->
            <!-- End Name Field -->
              <!-- Start Description Field -->
              <div class="form-group form-group-lg"> 
                <label class="col-sm-2 control-lable">Description</label>
                <div class="col-sm-10 col-md-6">
                <input type="text" name="description" class="form-control" 
                placeholder="Description Of The Item"/>
                <span class="asterisk">*</span>
            </div>
            </div>
            <!-- End Description Field -->
             <!-- Start Price Field -->
             <div class="form-group form-group-lg">
                <label class="col-sm-2 control-lable">Price</label>
                <div class="col-sm-10 col-md-6">
                <input type="text" name="price" class="form-control" required="required" 
                placeholder="Price Of The Item"/>
                <span class="asterisk">*</span>
            </div>
            </div>
            <!-- End Price Field -->
             <!-- Start Country Field -->
             <div class="form-group form-group-lg">
                <label class="col-sm-2 control-lable">Country</label>
                <div class="col-sm-10 col-md-6">
                <input type="text" name="country" class="form-control" 
                placeholder="Country Of Made"/>
                <span class="asterisk">*</span>
            </div>
            </div>
            <!-- End Price Field -->
             <!-- Start Status Field -->
             <div class="form-group form-group-lg">
                <label class="col-sm-2 control-lable">Status</label>
                <div class="col-sm-10 col-md-6">
                <select class="form-control" name="status" >
                    <option value="0">...</option>
                    <option value="1">New</option>
                    <option value="2">Like New</option>
                    <option value="3">Used</option>
                    <option value="4">Very old</option>
                </select>
            </div>
            </div>
            <!-- End Status Field -->
              <!-- Start Rating Field -->
              <div class="form-group form-group-lg">
                <label class="col-sm-2 control-lable">Rating</label>
                <div class="col-sm-10 col-md-6">
                <select class="form-control" name="rating" >
                    <option value="0">...</option>
                    <option value="1">*</option>
                    <option value="2">**</option>
                    <option value="3">***</option>
                    <option value="4">****</option>
                    <option value="5">*****</option>
                </select>
            </div>
            </div>
            <!-- End Rating Field -->
            <!-- Start Submit Field -->
        <div class="form-group form-group-lg">
            <div class="col-sm-offset-2 col-sm-10">
                <input type="submit" value="Add Item" class="btn btn-primary btn-sm" />
            </div>
        </div>
         <!-- End Submit Field -->
    </form>

     </div>

     <?php   

    }elseif($do == 'Insert'){

        if($_SERVER['REQUEST_METHOD'] == 'POST' ){

            echo '<h1 class="text-center">Update Item</h1>';
            echo '<div class="container">';
    
             $name   = $_POST[$names];                      
             $desc   = $_POST['description'];
             $price  = $_POST['price'];
             $country   = $_POST['country'];
             $status  = $_POST['status'];
             
    
             
           
    
             $formErrors = array();
    
             if(empty($name)){
    
               $formErrors[] = 'Username Cant Be Less Than <strong>4 Characters</strong>';
               
             } if(empty($desc)){
    
             $formErrors[] = 'Username Cant Be More Than <strong>20 Characters</strong>';
             
             }if(empty($price)){
    
                $formErrors[] = 'Username Cant Be <strong>Empty</strong>';
    
             }if(empty($country)){
    
              $formErrors[] = 'Password Cant Be <strong>Empty</strong>';
    
           } if($status == 0){
    
               $formErrors[] = 'Full Name Cant Be <strong>Empty</strong>';
           }  
    
             foreach($formErrors as $error){
               echo  '<div class="alert alert-danger">'. $error .'</div>'. '<br/>';
             }
         
             if (empty($formErrors)){
    
    
               $stmt = $con->prepare("INSERT INTO items(Name, Description, Price, Country_Made , Status , Add_Date)
                                                  VALUES(:zuser, :zdesc, :zprice, :zcountry,zstatus,now())");
               $stmt->execute(array( 'zname' => $name , 
                                     'zdesc' => $desc , 
                                     'zprice' => $price ,
                                     'zcountry' => $country ,                               
                                     'zstatus' => $status , 
                                    ));  
     
               $theMsg = "<div class='alert alert-success'>" . $stmt->rowCount() . 'Record Updated</div>';
               redirectHome($theMsg , 'back');
             
                
    
             }
    
    
           }else {
    
              echo "<div class='container'>";
    
              $theMsg = '<div class="alert alert-danger">Sorry You Cant Browse This Page Directly</div>';
    
              redirectHome($theMsg);
    
              echo "</div>";
           }
    
           echo '</div>';
        
    }elseif($do == 'Edit'){
        
    }elseif($do == 'Update'){
        
    }elseif($do == 'Delete'){
        
    }elseif($do == 'Approve'){
          
    }

    include 'includes/templates/footer.php';


} else {
    header("Location: index.php");  
    exit();
}

ob_end_flush();

?>