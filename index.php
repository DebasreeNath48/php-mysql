<!DOCTYPE html>
<html>
<head>
	<meta charset="utf-8">
	<meta name="viewport" content="width=device-width, initial-scale=1">
	<title>CRUD OPERATIONS</title>
</head>
<body>
	<form action ="#" method = "post">
		<input type="email" name="email" placeholder="enter email">
		<br>
		<input type="text" name="name" placeholder="enter name">
		<br>
		<input type="number" name="roll" placeholder="enter roll">
		<br>
		<input type="date" name="date_of_birth" placeholder="enter dob">
		<br>
		<input type="text" name="city" placeholder="enter city">
		<br>
		<input type="submit" name="submit" value="add">
	</form>
	<fieldset>
		<legend>search record</legend>
		<form action = "#" method="post">
			<input type="number" placeholder="enter roll to search" name="search_roll" required>
			<button name="search_button">search</button>
		</form>
	</fieldset>
	<br>
	<form action = "#" method = "post">
		<button name = "show">show data</button>
	</form>
	

<?php
	
	function showtable(){
		include("./conn.php");
		$query = "select * from student";
		$result = mysqli_query($conn,$query);
		echo "<table border=1>";?>
			<tr>
				<th>email</th>
				<th>name</th>
				<th>roll</th>
				<th>delete</th>
			</tr>
		<?php	
		for($i=0;$i<mysqli_num_rows($result);$i++){
			$row = mysqli_fetch_assoc($result);?>
				
			<tr>
				<td><?php echo $row['email']?></td>
				<td><?php echo $row['name']?></td>
				<td><?php echo $row['roll']?></td>
				<td>
					<form method="post">
						<input style="display:none" name="invisible" value=<?php echo $row['roll']?>>
						<button name = "delete">delete</button>
					</form>
				</td>		
			</tr>
			<?php
			echo "<br>";	
		}
		echo "</table>";
		mysqli_close($conn);
	}
?>
<?php
	include("./conn.php");
	if($_SERVER['REQUEST_METHOD'] == "POST"){
		if(isset($_POST['submit'])){
			$email = $_POST['email'];
			$name = $_POST['name'];
			$roll = $_POST['roll'];
			$dob = $_POST['date_of_birth'];
			$city = $_POST['city'];

			$sql = "insert into student values('$email','$name',$roll,'$dob','$city')";

			$result = mysqli_query($conn,$sql);
			//echo "insertion successfull";

		}
		else if(isset($_POST['show'])){
			showtable();
		}
		else if(isset($_POST['delete'])){
			$id = $_POST['invisible'];
			$query = "delete from student where roll=$id";
			mysqli_query($conn,$query);
			showtable();
		}
		else if(isset($_POST['search_button'])){
			$roll = $_POST['search_roll'];
			$query = "select * from student where roll=$roll";
			$res = mysqli_query($conn,$query);
			$row = mysqli_fetch_assoc($res);
			if(mysqli_num_rows($res)==1){
				//successful search
				?>
				<form action ="#" method="post">
					<fieldset>
						<legend>update record</legend>

							<input name="invisible_roll" style="display:none;" value=<?php echo $row['roll']?>>

							<label>email</label>
							<input required type ="email" name="update_email" value=<?php echo $row['email'];?>>

							<label>name</label>
							<input required type ="text" name="update_name" value=<?php echo $row['name'];?>>

							<label>roll</label>
							<input required type ="number" name="update_roll" value=<?php echo $row['roll'];?>>
							<button name="updatebutton">update</button>
					</fieldset>
				</form>
				<?php
			}
			else{
				echo "<h3>no records found</h3>";
			}
		}
		else if(isset($_POST['updatebutton'])){
			$email = $_POST['update_email'];
			$name = $_POST['update_name'];
			$roll = $_POST['update_roll'];
			$original=$_POST['invisible_roll'];
			$query = "update student set name='$name',email='$email',roll = $roll where roll=$original";
			mysqli_query($conn,$query);
			echo "<h3>record modified";
			showtable();
		}
}
?>
</body>
</html>