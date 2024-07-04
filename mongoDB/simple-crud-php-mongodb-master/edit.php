<?php
// including the database connection file
include_once("config.php");
use MongoDB\BSON\ObjectId;

if(isset($_POST['update']))
{	
	$id = $_POST['id'];
	$user = array (
				'name' => $_POST['name']
			);
	
	// checking empty fields
	$errorMessage = '';
	foreach ($user as $key => $value) {
		if (empty($value)) {
			$errorMessage .= $key . ' field is empty<br />';
		}
	}
			
	if ($errorMessage) {
		// print error message & link to the previous page
		echo '<span style="color:red">'.$errorMessage.'</span>';
		echo "<br/><a href='javascript:self.history.back();'>Go Back</a>";	
	} else {
		//updating the 'users' table/collection
		$objectId = new ObjectId($id);
		$db->clt_files->updateOne(
						array('_id' => $objectId),
						array('$set' => $user)
					);
		
		//redirectig to the display page. In our case, it is index.php
		header("Location: index.php");
	}
} // end if $_POST
?>
<?php
//getting id from url
$id = $_GET['id'];

//selecting data associated with this particular id
//$result = $db->clt_files->findOne(array('_id' => new ObjectId($id)));
$objectId = new ObjectId($id);

$result = $db->clt_files->findOne(
	array('_id' => $objectId)
);
echo json_encode($result). '<br> -';

$name = $result['name'];
// $age = $result['age'];
// $email = $result['email'];
?>
<html>
<head>	
	<title>Edit Data</title>
</head>

<body>
	<a href="index.php">Home</a>
	<br/><br/>
	
	<form name="form1" method="post" action="edit.php">
		<table border="0">
			<tr> 
				<td>Name</td>
				<td><input type="text" name="name" value="<?php echo $name;?>"></td>
			</tr>
			<!-- <tr> 
				<td>Age</td>
				<td><input type="text" name="age" value="?php echo $age;?>"></td>
			</tr>
			<tr> 
				<td>Email</td>
				<td><input type="text" name="email" value="?php echo $email;?>"></td>
			</tr> -->
			<tr>
				<td><input type="hidden" name="id" value=<?php echo $_GET['id'];?>></td>
				<td><input type="submit" name="update" value="Update"></td>
			</tr>
		</table>
	</form>
</body>
</html>
