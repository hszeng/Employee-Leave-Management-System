<?php
// check if top.inc.php is defined. if not defined it will not work.
require('top.inc.php');
// retriving name
$name='';
// retriving email
$email='';
// retriving mobile
$mobile='';
// retriving department_id
$department_id='';
// retriving address
$address='';
// retriving birthday
$birthday='';
// retriving id
$id='';
// get id from url
if(isset($_GET['id'])){
	$id=mysqli_real_escape_string($con,$_GET['id']);
	/* 
		shows only user profile. so that he can not go to other user profile through url.
		if user is not admin he can not go to others profile.
	*/
	if($_SESSION['ROLE']==2 && $_SESSION['USER_ID']!=$id){
		// // if user is not admin he can not access add_employee page.
		die('Access denied');
	}
	// which employee needed to edit, it will take to that employee id
	$res=mysqli_query($con,"select * from employee where id='$id'");
	$row=mysqli_fetch_assoc($res);
	$name=$row['name'];
	$email=$row['email'];
	$mobile=$row['mobile'];
	$department_id=$row['department_id'];
	$address=$row['address'];
	$birthday=$row['birthday'];
}
if(isset($_POST['submit'])){
	$name=mysqli_real_escape_string($con,$_POST['name']);
	$email=mysqli_real_escape_string($con,$_POST['email']);
	$mobile=mysqli_real_escape_string($con,$_POST['mobile']);
	$password=mysqli_real_escape_string($con,$_POST['password']);
	$department_id=mysqli_real_escape_string($con,$_POST['department_id']);
	$address=mysqli_real_escape_string($con,$_POST['address']);
	$birthday=mysqli_real_escape_string($con,$_POST['birthday']);
	if($id>0){
		// id > 0 when id will retrive from url, when id > 0 update that employee
		$sql="update employee set name='$name',email='$email',mobile='$mobile',password='$password',department_id='$department_id',address='$address',birthday='$birthday' where id='$id'";
	}else{
		// when id < 0 insert employee
		$sql="insert into employee(name,email,mobile,password,department_id,address,birthday,role) values('$name','$email','$mobile','$password','$department_id','$address','$birthday','2')";
	}
	mysqli_query($con,$sql);
	header('location:employee.php');
	// exit current php script
	die();
}
?>
<div class="content pb-0">
            <div class="animated fadeIn">
               <div class="row">
                  <div class="col-lg-12">
                     <div class="card">
                        <div class="card-header"><strong>Edit Employee</strong><small> Form</small></div>
                        <div class="card-body card-block">
                           <form method="post">
							   <div class="form-group">
									<label class=" form-control-label">Name</label>
									<input type="text" value="<?php echo $name?>" name="name" placeholder="Enter employee name" class="form-control" required>
								</div>
								<div class="form-group">
									<label class=" form-control-label">Email</label>
									<input type="email" value="<?php echo $email?>" name="email" placeholder="Enter employee email" class="form-control" required>
								</div>
								<div class="form-group">
									<label class=" form-control-label">Mobile</label>
									<input type="text" value="<?php echo $mobile?>" name="mobile" placeholder="Enter employee mobile" class="form-control" required>
								</div>
								<div class="form-group">
									<label class=" form-control-label">Password</label>
									<input type="password"  name="password" placeholder="Enter employee password" class="form-control" required>
								</div>
								<div class="form-group">
									<label class=" form-control-label">Department</label>
									<!--department will be dropdown menu-->
									<select name="department_id" required class="form-control">
										<option value="">Select Department</option>
										<?php
										// department will be displayed based on their name
										$res=mysqli_query($con,"select * from department order by department desc");
										// show department in dropdown. retrive all department from database.
										while($row=mysqli_fetch_assoc($res)){
											if($department_id==$row['id']){
												echo "<option selected='selected' value=".$row['id'].">".$row['department']."</option>";
											}else{
												echo "<option value=".$row['id'].">".$row['department']."</option>";
											}
										}
										?>
									</select>
								</div>
								<div class="form-group">
									<label class=" form-control-label">Address</label>
									<input type="text" value="<?php echo $address?>" name="address" placeholder="Enter employee address" class="form-control" required>
								</div>
								<div class="form-group">
									<label class=" form-control-label">Birthday</label>
									<input type="date" value="<?php echo $birthday?>" name="birthday" placeholder="Enter employee birthday" class="form-control" required>
								</div>
							   <?php 
							   // if user enter as admin then it will show only  
							   if($_SESSION['ROLE']==1){?>
							   <button  type="submit" name="submit" class="btn btn-lg btn-info btn-block">
							   <span id="payment-button-amount">Submit</span>
							   </button>
							   <?php } ?>
							  </form>
                        </div>
                     </div>
                  </div>
               </div>
            </div>
         </div>
                  
<?php
require('footer.inc.php');
?>