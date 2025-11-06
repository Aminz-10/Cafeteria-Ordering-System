<?php
    $currentDirectory = getcwd();
    $uploadDirectory = "/upload/";

    $errors = array();

    $fileExtensionsAllowed = array('jpeg','jpg','png');

    $fileName = $_FILES['the_file']['name'];
    $fileSize = $_FILES['the_file']['size'];
    $fileTmpName  = $_FILES['the_file']['tmp_name'];
    $fileType = $_FILES['the_file']['type'];
    $fileExtension = strtolower(end(explode('.',$fileName)));

    $uploadPath = $currentDirectory . $uploadDirectory . basename($fileName); 

    if (isset($_POST['submit'])) {

      if (! in_array($fileExtension,$fileExtensionsAllowed)) {
        $errors[] = "This file extension is not allowed. Please upload a JPEG or PNG file";
      }

      if ($fileSize > 8000000) {
        $errors[] = "File exceeds maximum size (4MB)";
      }

      if (empty($errors)) {
        $didUpload = move_uploaded_file($fileTmpName, $uploadPath);

        if ($didUpload) {
		echo '<script type="text/javascript">alert("The file ' . basename($fileName) . ' has been uploaded");window.location = "try.php";</script>';
        } else {
		echo '<script>alert("An error occurred. Please contact the administrator.")</script>';
        }
      } else {
        foreach ($errors as $error) {
		echo '<script type="text/javascript">alert(" ' . $error . ' These are the errors");window.location = "try.php";</script>';
        }
      }

    }
?>