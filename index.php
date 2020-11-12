<?php
// check if top.inc.php is defined. if not defined it will not work.
require('top.inc.php');
// if user is not admin he can not access index page.
if($_SESSION['ROLE']!=1){
   // get id from url
   header('location:add_employee.php?id='.$_SESSION['USER_ID']);
   // exit current php script
	die();
}
// if get type from url && id then 
if(isset($_GET['type']) && $_GET['type']=='delete' && isset($_GET['id'])){
   // get id for delete from database
   $id=mysqli_real_escape_string($con,$_GET['id']);
   // delete department form database
	mysqli_query($con,"delete from department where id='$id'");
}
// "order by id desc" is used to show recent added department first
$res=mysqli_query($con,"select * from department order by id desc");
?>
<div class="content pb-0">
            <div class="orders">
               <div class="row">
                  <div class="col-xl-12">
                     <div class="card">
                        <div class="card-body">
                           <h4 class="box-title">Department</h4>
						   <h4 class="box_title_link"><a href="add_department.php">Add Department</a> </h4>
                        </div>
                        <div class="card-body--">
                           <div class="table-stats order-table ov-h">
                              <table class="table ">
                                 <thead>
                                    <tr>
                                       <!--width is used for give space ratio for the element-->
                                       <th width="5%">S.No</th>
                                       <th width="5%">ID</th>
                                       <th width="70%">Department Name</th>
                                       <th width="20%"></th>
                                    </tr>
                                 </thead>
                                 <tbody>
                                    <?php 
                           // give serial number to dummy data
                           $i=1;
                           // retrive dummy data from database
									while($row=mysqli_fetch_assoc($res)){?>
									<tr>
                              <!--for serial no-->
                              <td><?php echo $i?></td>
                              <!--for id-->
									   <td><?php echo $row['id']?></td>
                              <!--for department-->
                              <td><?php echo $row['department']?></td>
                              <!--for edit & delete link-->
                              <!--when goto add_department it will take existing id + 1 with it-->
									   <td><a href="add_department.php?id=<?php echo $row['id']?>">Edit</a> <a href="index.php?id=<?php echo $row['id']?>&type=delete">Delete</a></td>
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
// check if footer.inc.php is defined. if not defined it will not work.
require('footer.inc.php');
?>