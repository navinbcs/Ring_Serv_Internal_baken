<?php 
error_reporting(E_ALL);
ini_set('display_errors', 1);
// Directory where the image will be saved
$target_dir = "uploads/";
if (isset($_POST["submit"])) {
print_r($_FILES); exit ;
}

?>

<!-- HTML form for file upload -->
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Image Upload</title>
</head>
<body>

    <h2>Upload an Image</h2>

    <form action="" method="post" enctype="multipart/form-data">
        Select image to upload:
        <input type="file" name="fileToUpload" id="fileToUpload" required>
        <input type="submit" value="Upload Image" name="submit">
    </form>

</body>
</html>
