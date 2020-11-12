<?php
// check if top.inc.php is defined. if not defined it will not work.
require('top.inc.php');

// delete leave
if(isset($_GET['type']) && $_GET['type']=='delete' && isset($_GET['id'])){
	$id=mysqli_real_escape_string($con,$_GET['id']);
	// leave is a reserved keyword. so using tenlda to specify leave as a user text
	mysqli_query($con,"delete from `leave` where id='$id'");
}
// update leave
if(isset($_GET['type']) && $_GET['type']=='update' && isset($_GET['id'])){
	$id=mysqli_real_escape_string($con,$_GET['id']);
	$status=mysqli_real_escape_string($con,$_GET['status']);
	// leave is a reserved keyword. so using tenlda to specify leave as a user text
	mysqli_query($con,"update `leave` set leave_status='$status' where id='$id'");
}
// only admin can not access leave page.
if($_SESSION['ROLE']==1){ 
	// leave is a reserved keyword. so using tenlda to specify leave as a user text
	$sql="select `leave`.*, employee.name,employee.id as eid from `leave`,employee where `leave`.employee_id=employee.id order by `leave`.id desc";
}else{
	// get employee id
	$eid=$_SESSION['USER_ID'];
	// leave is a reserved keyword. so using tenlda to specify leave as a user text
	$sql="select `leave`.*, employee.name ,employee.id as eid from `leave`,employee where `leave`.employee_id='$eid' and `leave`.employee_id=employee.id order by `leave`.id desc";
}
$res=mysqli_query($con,$sql);
?>
<div class="content pb-0">
            <div class="orders">
               <div class="row">
                  <div class="col-xl-12">
                     <div class="card">
                        <div class="card-body">
                           <h4 class="box-title">Leave </h4>
							<?php 
							// admin can not apply for leave
							if($_SESSION['ROLE']==2){ ?>
						   <h4 class="box_title_link"><a href="add_leave.php">Add Leave</a> </h4>
						   <?php } ?>
                        </div>
                        <div class="card-body--">
                           <div class="table-stats order-table ov-h">
                              <table class="table ">
                                 <thead>
                                    <tr>
									   <!--width is used for give space ratio for the element-->
                                       <th width="5%">S.No</th>
                                       <th width="5%">ID</th>
									   <th width="15%">Employee Name</th>
                                       <th width="14%">From</th>
									   <th width="14%">To</th>
									   <th width="15%">Description</th>
									   <th width="18%">Leave Status</th>
									   <th width="10%"></th>
                                    </tr>
                                 </thead>
                                 <tbody>
                                    <?php 
									$i=1;
									while($row=mysqli_fetch_assoc($res)){?>
									<tr>
                                       <td><?php echo $i?></td>
									   <td><?php echo $row['id']?></td>
									   <td><?php echo $row['name'].' ('.$row['eid'].')'?></td>
                                       <td><?php echo $row['leave_from']?></td>
									   <td><?php echo $row['leave_to']?></td>
									   <td><?php echo $row['leave_description']?></td>
									   <td>
										   <?php
										    // if status 1 then leave status Applied
											if($row['leave_status']==1){
												echo "Applied";
											}
											// if status 2 then leave status Approved
											if($row['leave_status']==2){
												echo "Approved";
											}
											// if status 2 then leave status Rejected
											if($row['leave_status']==3){
												echo "Rejected";
											}
										   ?>
										   <?php 
										   // only admin can update leave status
										   // show dropdown for admin to update leave application
										   if($_SESSION['ROLE']==1){ ?>
										   <select class="form-control" onchange="update_leave_status('<?php echo $row['id']?>',this.options[this.selectedIndex].value)">
											<option value="">Update Status</option>
											<!--if value 2 then leave status Approved-->
											<option value="2">Approved</option>
											<!--if value 2 then leave status Rejected-->
											<option value="3">Rejected</option>
										   </select>
										   <?php } ?>
									   </td>
									   <td>
									   <?php
									   // leave request can only be deleted if it is Applied
									   if($row['leave_status']==1){ ?>
									   <!---->
									   <a href="leave.php?id=<?php echo $row['id']?>&type=delete">Delete</a>
									   <?php } ?>
									   
									   
									   </td>
									   
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
		  <!--JavaScript-->
         <script>
		 // display changes after update leave status
		 function update_leave_status(id,select_value){
			// location where need to update
			window.location.href='leave.php?id='+id+'&type=update&status='+select_value;
		 }
		 </script>
<?php
// check if footer.inc.php is defined. if not defined it will not work.
require('footer.inc.php');
?>