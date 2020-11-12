<?php
// check if top.inc.php is defined. if not defined it will not work.
require('top.inc.php');
// if user is not admin he can not access employee page.
if($_SESSION['ROLE']!=1){
   // get id from url
   header('location:add_employee.php?id='.$_SESSION['USER_ID']);
   // exit current php script
	die();
}
// if get type from url && id then 
if(isset($_GET['type']) && $_GET['type']=='delete' && isset($_GET['id'])){
   $id=mysqli_real_escape_string($con,$_GET['id']);
   // delete leave type form database
	mysqli_query($con,"delete from leave_type where id='$id'");
}
// "order by id desc" is used to show recent leave type first
$res=mysqli_query($con,"select * from leave_type order by id desc");
?>
<div class="content pb-0">
            <div class="orders">
               <div class="row">
                  <div class="col-xl-12">
                     <div class="card">
                        <div class="card-body">
                           <h4 class="box-title">Leave Type </h4>
						   <h4 class="box_title_link"><a href="add_leave_type.php">Add Leave Type</a> </h4>
                        </div>
                        <div class="card-body--">
                           <div class="table-stats order-table ov-h">
                              <table class="table ">
                                 <thead>
                                    <tr>
                                    <!--width is used for give space ratio for the element-->
                                       <th width="5%">S.No</th>
                                       <th width="5%">ID</th>
                                       <th width="70%">Leave Type</th>
                                       <th width="20%"></th>
                                    </tr>
                                 </thead>
                                 <tbody>
                                    <?php 
									$i=1;
									while($row=mysqli_fetch_assoc($res)){?>
									<tr>
                                       <td><?php echo $i?></td>
									   <td><?php echo $row['id']?></td>
                                       <td><?php echo $row['leave_type']?></td>
									   <td><a href="add_leave_type.php?id=<?php echo $row['id']?>">Edit</a> <a href="leave_type.php?id=<?php echo $row['id']?>&type=delete">Delete</a></td>
                                    </tr>
									<?php 
									$i++;
									} ?>
                                 </tbody>
                              </table>
                           </div>
                        </div>
                     </div>
                  </div>
               </div>
            </div>
		  </div>
         
<?php
require('footer.inc.php');
?>