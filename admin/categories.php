<?php


 ob_start();

 session_start();

 $pageTitle = 'Categories';

 if(isset($_SESSION['Username'])){


    include 'init.php';

    $do = isset($_GET['do']) ? $_GET['do'] : 'Manage' ;

    if($do == 'Manage'){

      $sort = 'ASC';

      $sort_array = array('ASC', 'DESC');

      if (isset($_GET['sort']) && in_array($_GET['sort'], $sort_array)){

        $sort = $_GET['sort'];
      }

      $stmt2 = $con->prepare("SELECT * FROM categories ORDER BY Ordering $sort");

      $stmt2->execute();

      $cats = $stmt2->fetchAll(); ?>
<style>

/* .categories .panel-body{
  padding:0;
}  */

/* .categories hr {
  margin-top: 5px;
  margin-bottom:5px;
} */
/* .categories .cat {
  padding: 15px;
  position:relative;
} */
.categories .cat h3 {
  margin: 0 0 10px;
}

.categories  .cat:last-of-type ~ hr{
  display:none;
}
.categories .cat .visibility {
    background-color: #c0392b;
    color: #FFF;
    padding: 4px 6px;
    margin-right: 6px;
    border-radius: 6px;
}

.categories .cat .commenting {
    background-color: #2c3e50;
    color: #FFF;
    padding: 4px 6px;
    margin-right: 6px;
    border-radius: 6px;
}

.categories .cat .advertises {
    background-color: #c0392b;
    color: #FFF;
    padding: 4px 6px;
    margin-right: 6px;
    border-radius: 6px;
}

/* .categories hr{

  margin-top:5px;
  margin-bottom:5px;
} */
/* .categories .cat{
  padding:15px;
  postion:relative;
  overflow:hidden;
} */

.categories .cat .hidden-buttons:hover{
    background-color: #EEE;
}

.categories .cat:hover .hidden-buttons{
  right:10px;
  
}

.categories .cat .hidden-buttons a{
  float:right;
}


.categories .cat .hidden-buttons a {
   margin-right:5px;
}

/* 
.categories .cat .hidden-buttons{
  -webkit-transition: all .5e ease-in-out;
  -moz-transition: all .5e ease-in-out;
  transition:all .5e ease-in-out;
  position:absolute;
  top:15px;
  right: -120px;
} */


.categories .cat .hidden-buttons a{
  margin-right:5px;
}
</style>


       <h1 class="text-center">Manage Categories</h1>
       <div class="container categories">
        <div class="panel panel-default">
        <div class="panel-heading">Manage Categories
          <div class="ordering pull-right">
            Ordering:
            <a class="<?php if ($sort == 'ASC') {echo 'active' ;} ?>" href="?sort=ASC">ASC</a>
            <a class="<?php if ($sort == 'DESC') {echo 'active' ;} ?>" href="?sort=DESC">Desc</a>
          </div>
        </div>
        <div class="panel-body">
          <?php
           foreach($cats as $cat){
              echo "<div class='cat'>";
              echo "<div class='hidden-buttons'>";
              echo "<a href='categories.php?do=Edit&catid=".$cat['ID']."' class='btn btn-xs btn-primary'><i class='fa fa-edit'></i>Edit</a>";
              echo "<a href='categories.php?do=Delete&catid=".$cat['ID']."' class='btn btn-xs btn-danger'><i class='fa fa-close'></i>Delete</a>";
              echo "</div>";
              echo "<h3>". $cat['Name'] . "</h3>";
              echo "<p>"; if($cat['Description'] == ''){ echo 'This category has no description';} else { echo $cat['Description']; }  "<p>";
               if($cat['Visibility'] == 1){ echo '<span class="Visibility">Hidden</span>';}
               if($cat['Allow_Comment'] == 1){ echo '<span class="commenting">Comment Hidden</span>';}
               if($cat['Allow_Ads'] == 1){ echo '<span class="advertises">Ads Disabled</span>';}           
              echo "</div>";
              echo "<hr>";
           }
          ?>
        </div>
        </div>           
        <a class="btn btn-primary" href="categories.php?do=Add"><i class="fa fa-plus"></i>Add New Category</a>
       </div>
         
     <?php

    }elseif ($do == 'Add') {?>

<h1 class="text-center">Add New Category</h1>
          <div class="container">
             
     <form class="form-horizontal" action="?do=Insert" method="POST">
       <input type="hidden" name="userid" value="<?php echo $userid ?>">
         <div class="form-group form-group-lg">
           <label class="col-sm-2 control-label">Name</label>
           <div class="col-sm-10 col-md-4">
               <input type="text" name="name" class="form-control" autocomplete="off" required="required" placeholder="Name of The Category"/>
           </div>
         </div>


         <div class="form-group form-group-lg">
           <label class="col-sm-2 control-label">Description</label>
           <div class="col-sm-10 col-md-4">
               <input type="text" name="description" class="form-control"  autocomplete="new-password" required="required" placeholder="Description The Category" />              
           </div>
         </div>

         <div class="form-group form-group-lg">
           <label class="col-sm-2 control-label">Ordering</label>
           <div class="col-sm-10 col-md-4">
               <input type="text" name="ordering"  class="form-control" placeholder="Number To Arrange The Categories"/>
           </div>
         </div>
               <!-- //////////////////////////////////////////////////// -->
         
         <div class="form-group form-group-lg">
           <label class="col-sm-2 control-label">Visible</label>
           <div class="col-sm-10 col-md-4">
              <div>
                  <input id="vis-yes" type="radio" name="visibility" value="0" checked />
                  <label for="vis-yes">Yes</label>
              </div>
              <div>
                  <input id="vis-no" type="radio" name="visibility" value="1" />
                  <label for="vis-no">No</label>
              </div>
           </div>
         </div>


         <div class="form-group form-group-lg">
           <label class="col-sm-2 control-label">Allow Commenting</label>
           <div class="col-sm-10 col-md-4">
              <div>
                  <input id="com-yes" type="radio" name="commenting" value="0" checked />
                  <label for="com-yes">Yes</label>
              </div>
              <div>
                  <input id="com-no" type="radio" name="commenting" value="1" />
                  <label for="com-no">No</label>
              </div>
           </div>
         </div>



         <div class="form-group form-group-lg">
           <label class="col-sm-2 control-label">Allow Ads</label>
           <div class="col-sm-10 col-md-4">
              <div>
                  <input id="ads-yes" type="radio" name="ads" value="0" checked />
                  <label for="ads-yes">Yes</label>
              </div>
              <div>
                  <input id="ads-no" type="radio" name="ads" value="1" />
                  <label for="ads-no">No</label>
              </div>
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
    
    }elseif ($do == 'Insert') {

           
       if($_SERVER['REQUEST_METHOD'] == 'POST' ){

        echo '<h1 class="text-center">Update Category</h1>';
        echo '<div class="container">';

         $name     = $_POST['name'];
         $desc     = $_POST['description'];
         $order    = $_POST['ordering'];
         $visible  = $_POST['visibility'];
         $comment  = $_POST['commenting'];
         $ads      = $_POST['ads'];

                

           $check = checkItem("Name" , "categories" , $name);

           if($check == 1){
               
              $theMsg = '<div class="alert alert-danger">Sorry Category User Is Exist</div>';
              redirectHome($theMsg,'back');

           }else{

           $stmt = $con->prepare("INSERT INTO categories(Name, Description, Ordering, Visibility , Allow_Comment , Allow_Ads)
                          VALUES(:zname, :zdesc, :zorder, :zvisible, :zcomment , :zads)");
           $stmt->execute(array( 'zname'    => $name , 
                                 'zdesc'    => $desc , 
                                 'zorder'   => $order ,
                                 'zvisible' => $visible ,
                                 'zcomment' => $comment ,                                
                                 'zads'     => $ads                                                                
                                ));  
 
           $theMsg = "<div class='alert alert-success'>" . $stmt->rowCount() . 'Record Updated</div>';
           redirectHome($theMsg , 'back');
         
            }

        }


      else {

          echo "<div class='container'>";

          $theMsg = '<div class="alert alert-danger">Sorry You Cant Browse This Page Directly</div>';

          redirectHome($theMsg , 'back');

          echo "</div>";
       }

       echo '</div>';


      

    }elseif ($do == 'Edit') {



      $catid = isset($_GET['catid']) && is_numeric($_GET['catid']) ? intval($_GET['catid']) : 0 ;


      $stmt = $con->prepare("SELECT * FROM categories WHERE  ID = ? ");

      $stmt->execute(array($catid));

      $cat = $stmt->fetch();

      $count = $stmt->rowCount();

    

     
    if($count > 0){?>

                <h1 class="text-center">Edit Category</h1>
                          <div class="container">
                            
                    <form class="form-horizontal" action="?do=Update" method="POST">
                      <input type="hidden" name="catid" value="<?php echo $catid ?>">
                        <div class="form-group form-group-lg">
                          <label class="col-sm-2 control-label">Name</label>
                          <div class="col-sm-10 col-md-4">
                              <input type="text" name="name" class="form-control"  required="required" placeholder="Name Of The Category" value="<?php echo $cat['Name'] ?>"/>
                          </div>
                        </div>


                        <div class="form-group form-group-lg">
                          <label class="col-sm-2 control-label">Description</label>
                          <div class="col-sm-10 col-md-4">
                              <input type="text" name="description" class="form-control" value="<?php echo $cat['Description'] ?>" />              
                          </div>
                        </div>

                        <div class="form-group form-group-lg">
                          <label class="col-sm-2 control-label">Ordering</label>
                          <div class="col-sm-10 col-md-4">
                              <input type="text" name="ordering"  class="form-control" placeholder="Number To Arrange The Categories" value="<?php echo $cat['Ordering'] ?>"/>
                          </div>
                        </div>
                              <!-- //////////////////////////////////////////////////// -->
                        
                        <div class="form-group form-group-lg">
                          <label class="col-sm-2 control-label">Visible</label>
                          <div class="col-sm-10 col-md-4">
                              <div>
                                  <input id="vis-yes" type="radio" name="visibility" value="0" <?php if ($cat['Visibility'] == 0 ){ echo 'checked';}?> />
                                  <label for="vis-yes">Yes</label>
                              </div>
                              <div>
                                  <input id="vis-no" type="radio" name="visibility" value="1" <?php if ($cat['Visibility'] == 1 ){ echo 'checked';}?> />
                                  <label for="vis-no">No</label>
                              </div>
                          </div>
                        </div>


                        <div class="form-group form-group-lg">
                          <label class="col-sm-2 control-label">Allow Commenting</label>
                          <div class="col-sm-10 col-md-4">
                              <div>
                                  <input id="com-yes" type="radio" name="commenting" value="0" <?php if ($cat['Allow_Comment'] == 0 ){ echo 'checked';}?> />
                                  <label for="com-yes">Yes</label>
                              </div>
                              <div>
                                  <input id="com-no" type="radio" name="commenting" value="1" <?php if ($cat['Allow_Comment'] == 1 ){ echo 'checked';}?> />
                                  <label for="com-no">No</label>
                              </div>
                          </div>
                        </div>



                        <div class="form-group form-group-lg">
                          <label class="col-sm-2 control-label">Allow Ads</label>
                          <div class="col-sm-10 col-md-4">
                              <div>
                                  <input id="ads-yes" type="radio" name="ads" value="0" <?php if ($cat['Allow_Ads'] == 0 ){ echo 'checked';}?> />
                                  <label for="ads-yes">Yes</label>
                              </div>
                              <div>
                                  <input id="ads-no" type="radio" name="ads" value="1" <?php if ($cat['Allow_Ads'] == 1 ){ echo 'checked';}?> />
                                  <label for="ads-no">No</label>
                              </div>
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
    
  }elseif ($do == 'Update') {
    echo '<h1 class="text-center">Update Category</h1>';
    echo '<div class="container">';
     
     if($_SERVER['REQUEST_METHOD'] == 'POST' ){

       $id       = $_POST['catid'];
       $name     = $_POST['name'];
       $desc     = $_POST['description'];
       $order    = $_POST['ordering'];
       $visible  = $_POST['visibility'];
       $comment  = $_POST['commenting'];
       $ads      = $_POST['ads'];

       $stmt = $con->prepare("UPDATE 
                                categories 
                              SET
                                 Name  = ? , 
                                 Description = ? , 
                                    Ordering = ? , 
                                    Visibility = ? ,
                                    Allow_Comment = ? ,
                                    Allow_Ads = ?
                                 WHERE
                                      ID =? ");
         $stmt->execute(array($name , $desc , $order ,$visible , $comment,$ads , $id));  

         
         $theMsg =  "<div class='alert alert-success'>" . $stmt->rowCount() . 'Record Updated</div>';
         // ['back'] = no redirect homepage
         redirectHome($theMsg , 'back');

       


     }else {

        $theMsg = '<div class="alert alert-danger">Sorry You Cant Browse This Page Directly</div>';
        //redirect HomePage
        redirectHome($theMsg);

     }
        echo "</div>";

        

    }elseif ($do =='Delete') {
       

      $catid = isset($_GET['catid']) && is_numeric($_GET['catid']) ? intval($_GET['catid']) : 0 ;


      $check = checkItem('ID', 'categories' , $catid);

       echo "<h1 class='text-center'>Delet Member</h1>";
       echo "<div class='container'>";

       if( $check > 0) {

         

           $stmt = $con->prepare("DELETE FROM categories WHERE ID = :zid");
           $stmt->bindParam(":zid" , $catid);
           $stmt->execute();
          
           $theMsg = "<div class='alert alert-success'>" . $stmt->rowCount() . 'Record Deleted</div>';

            redirectHome($theMsg);
           
         }else{

           $theMsg = '<div class="alert alert-danger">This ID is Not Exist</div>';
           redirectHome($theMsg);
         }

         echo '</div>' ;



    }



  
  
   
   
  
   
   include 'includes/templates/footer.php';

  
   } else{

  header('Location: index.php');  
  exit();
}

ob_end_flush();

?>