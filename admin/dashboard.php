<?php
    ob_start();

    session_start();
    // $noNavbar='';
    if(isset($_SESSION['Username'])){

      include 'init.php';


     $latestUsers = 5;

     $theLatest = getLatest("*","users","UserID", $latestUsers);
    
     ?>
     
<style>
.home-stats .stat {
    padding: 20px;
    font-size: 15px;
    color: #FFF;
    border-radius:10px;
}

.home.stats .stat a{
    color:#FFF;
}

.home.stats .stat a:hover{
    text-decoration:none;
}
.home-stats .stat span {
    display: block;
    font-size: 50px;
}

.home-stats .st-members {
    background-color: #3498db;
    
}

.home-stats .st-pending {
    background-color: #c0392b;
}

.home-stats .st-items {
    background-color: #d35400;
}

.home-stats .st-comments {
    background-color: #8e44ad;
}

.latest {
    margin-top: 30px;
}</style>
  <div class="home-stats">
    <div class="container text-center">
        <h1>Dashboard</h1>
        <div class="row">
            <div class="col-md-3">
                 <div class="stat st-members">
                 Total Members
                <span><a style="color:#fdfdfd;" href="members.php"><?php echo countItems('UserID' , 'users') ?></a></span>
            </div>
        </div>        
            <div class="col-md-3">
                 <div class="stat st-pending">
                Pending Members
                <span><a style="color:#fdfdfd;" href="members.php?do=Manage&page=Pending "><?php echo checkItem("RegStatus" , "users" , 0) ?></a></span>
            </div>
        </div>       
            <div class="col-md-3">
                 <div class="stat st-items">
                Total Items
                <span>1500</span>
            </div>
        </div>        
            <div class="col-md-3">
                 <div class="stat st-comments">
                Total Comments
                <span>3500</span>
            </div>
        </div>
     </div>
    </div>
    </div>

  <div class="latest">
    <div class="container ">
        <div class="row">
            <div class="col-sm-6">
                <div class="panel panel-default">
                     
                    <div class="panel-heading">
                    <i class="fa fa-users"></i> Latest <?php echo $latestUsers  ?> Registerd Users
                </div>
                <div class="panel-body">
                <ul class="list-unstyled latest-users">
                    <style>
                    .latest-users li {padding: 5px 0;overflow: hidden;}
                    .latest { margin-top: 30px;}
                    .latest-users {margin-bottom: 0;}
                    .latest-users li:nth-child(odd){background-color:#EEE;}
                    .latest-users .btn-success,
                    .latest-users .btn-info
                    {padding:2px 8px}
                    .latest-users .btn-info{
                        margin-right:5px;
                    }
                    
                    
                    </style>
                <?php                                 
                  foreach($theLatest as $user){
                    echo '<li>';
                       echo  $user['Username'];
                       echo '<a href="members.php?do=Edit&userid='.$user['UserID'].'">';
                          echo '<span class="btn btn-success pull-right">';
                             echo '<i class="fa fa-edit"></i></a>Edit';
                            if($user['RegStatus'] == 0){
                            echo "<a href='members.php?do=Activate&userid=".$user['UserID']."' class='btn btn-info pull-right activate'><i class='fa fa-close'></i>Activate</a>";
                                                      }
                           echo '</span>';
                       echo '</a>';
                    echo '</li>';
                  }                                  
                ?>
                </ul>
                 </div>
               </div>
            </div>

            <div class="col-sm-6">
                <div class="panel panel-default">
                    <div class="panel-heading">
                    <i class="fa fa-tag"></i> Latest Items
                </div>
                <div class="panel-body">
                Test
                 </div>
               </div>
            </div>

        </div>
     </div>
   </div>

     <?php



      include 'includes/templates/footer.php';
   

    }  else
    {
        header('Location: index.php');
        exit();
    }

    ob_end_flush();

?>