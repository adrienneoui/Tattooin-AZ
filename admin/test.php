<?php
if(isset($_POST['Submit']))
{
$current_image=$_FILES['image']['name'];
$extension = substr(strrchr($current_image, '.'), 1);
if (($extension!= "jpg") && ($extension != "jpeg"))
{
die('Unknown extension');
}
$time = date("fYhis");
$new_image = $time . "." . $extension;
$destination="upload/".$new_image;
$action = copy($_FILES['image']['tmp_name'], $destination);
if (!$action)
{
die('File copy failed');
}else{
echo "File copy successful";
}
}else{
?>
<form method="post" enctype="multipart/form-data" action="test.php">
<input type="file" name="image" ><br>
<input type="submit" name="Submit" value="submit">
</form>
<?php
}
?>

