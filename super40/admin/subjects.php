<!---------------- Session starts form here ----------------------->
<?php  
	session_start();
	if (!$_SESSION["LoginAdmin"])
	{
		header('location:../login/login.php');
	}
		require_once "../connection/connection.php";
		$success_message = '';
		$error_message ='';
		$message = '';
	?>
<!---------------- Session Ends form here ------------------------>

<?php  
	if (isset($_POST['sub'])) {
		$subject_code=$_POST['subject_code'];
		$subject_name=$_POST['subject_name'];
		$semester=$_POST['semester'];
		$course_code=$_POST['course_code'];
		$credit_hours=$_POST['credit_hours'];
		$pass_mark =  $_POST['passmmark'];
		$full_mark = $_POST['fullmark'];

		$query="insert into course_subjects(subject_code,subject_name,course_code,semester,credit_hours,total_mark,pass_mark)values('$subject_code','$subject_name','$course_code','$semester','$credit_hours',$full_mark,$pass_mark)";
		$run=mysqli_query($con,$query);
		if ($run) {
			$success_message = "Subject  Added Successfully";
		}
		else{
			if(str_contains(mysqli_error($con),'Duplicate')){
				$error_message = 'Duplicate Entry Subject  Code : '.$subject_code.' Already Present';
			}
			else{
				$error_message = "Subject  Add Operation Failed";
			}
			
		}
	}
?>


<!doctype html>
<html lang="en">
	<head>
		<title>Admin - Subjects</title>
	</head>
	<body>
		<?php include('../common/common-header.php') ?>
		<?php include('../common/admin-sidebar.php') ?>  

		<main role="main" class="col-xl-10 col-lg-9 col-md-8 ml-sm-auto px-md-4 mb-2 w-100">
			<div class="sub-main">
				<div class="bar-margin text-center d-flex flex-wrap flex-md-nowrap pt-3 pb-2 mb-3 text-white admin-dashboard pl-3">
					<h4>Subject Management System </h4>
				</div>

				<div class="col-md-12">
							<?php
								if($success_message){
									$bg_color = "alert-success";
									$message = $success_message;
								}
								else if($error_message){
									$bg_color = "alert-danger";	
									$message = $error_message;
								}
							?>
							<h5 class="py-2 pl-3 <?php echo $bg_color; ?>">
								
								<?php echo $message ?>
							</h5>
						</div>
				<div class="row">
					<div class="col-md-12">
						<form action="subjects.php" method="post">
							<div class="row mt-3">
								<div class="col-md-6">
									<div class="form-group">
										<label for="exampleInputEmail1">Subject Code: </label>
										<input type="text" name="subject_code" class="form-control" required placeholder="Enter Subject Code" required>
									</div>
								</div>
								<div class="col-md-6">
									<div class="form-group">
										<label for="exampleInputPassword1">Subject Name:</label>
										<input type="text" name="subject_name" class="form-control" required placeholder="Enter Subject Name" required>
									</div>
								</div>
							</div>
							<div class="row">
								<div class="col-md-6">
									<div class="form-group">
										<label for="exampleInputPassword1">Semester:</label>
										<input type="text" name="semester" class="form-control" required placeholder="Enter Semester" required>
									</div>
								</div>
								<div class="col-md-6">
									<div class="form-group">
										<label for="exampleInputEmail1">Course Code:</label>
										<select class="browser-default custom-select" name="course_code">
											<option >Select Course</option>
											<?php
											$query="select course_code from courses";
											$run=mysqli_query($con,$query);
											while($row=mysqli_fetch_array($run)) {
											echo	"<option value=".$row['course_code'].">".$row['course_code']."</option>";
											}
										?>
										</select>
									</div>
								</div>
							</div>
							<div class="row">
							<div class="col-md-6">
									<div class="form-group">
										<label for="exampleInputPassword1">Full Mark:</label>
										<input type="text" name="fullmark" class="form-control" required placeholder="Enter Full Mark" required>
									</div>
								</div>
								<div class="col-md-6">
									<div class="form-group">
										<label for="exampleInputPassword1">Passing Mark: </label>
										<input type="text" name="passmmark" class="form-control" required placeholder="Enter Passing Mark" required>
									</div>
								</div>

							</div>
							<div class="row">
								<div class="col-md-6">
									<div class="form-group">
										<label for="exampleInputPassword1">Credit Hours:</label>
										<input type="number" name="credit_hours" class="form-control"  placeholder="Enter Subject Credit Hours" required>
									</div>
								</div>
								

								<div class="col-md-6 mt-4">
									<div class="form-group pt-2">
										<input type="submit" name="sub" value="Add Subject" class="btn btn-primary">
									</div>
								</div>
							</div>
						</form>
					</div>
				</div>
				<div class="row">
					<div class="col-md-12 ml-2">
						<section class="mt-3">
							<table class="w-100 table-elements table-three-tr" cellpadding="3">
								<tr class="table-tr-head table-three text-white">
									<th>Sr.No</th>
									<th>Subject Code</th>
									<th>Subject Name</th>
									<th>Course Code</th>
									<th>Semester</th>
									<th>Credit Hours</th>
									<th>Pass Mark</th>
									<th>Full Mark</th>
									<th>Action</th>
								</tr>
								<?php
									$sr=1;
									$query="select subject_code,subject_name,course_code,semester,credit_hours,total_mark,pass_mark from course_subjects";
									$run=mysqli_query($con,$query);
									while($row=mysqli_fetch_array($run)) {
									echo	"<tr>";
									echo	"<td>".$sr++."</td>";
									echo	"<td>".$row['subject_code']."</td>";
									echo	"<td>".$row['subject_name']."</td>";
									echo	"<td>".$row['course_code']."</td>";
									echo	"<td>".$row['semester']."</td>";
									echo	"<td>".$row['credit_hours']."</td>";
									echo	"<td>".$row['pass_mark']."</td>";
									echo	"<td>".$row['total_mark']."</td>";
									echo	"<td width='20'><a class='btn btn-danger' href=delete-function.php?subject_code=".$row['subject_code'].">Delete</a></td>";
									echo	"</tr>";
									} 
								?>
							</table>				
						</section>
					</div>
				</div>
			</div>
		</main>
		<script type="text/javascript" src="../bootstrap/js/jquery.min.js"></script>
		<script type="text/javascript" src="../bootstrap/js/bootstrap.min.js"></script>
		<?php include('../common/common-footer.php') ?>
	</body>
</html>
