<html>
<head>
<meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1">
<title>Upload Image</title>
<link rel="stylesheet" href="css/bootstrap.min.css"> 
<link rel="stylesheet" href="css/style.css">
</head>
  
<body>
<div class="about-section-box">
<div class="container">
<div align="center">
    <form action="fileUploadScript.php" method="POST" enctype="multipart/form-data">
        <div><strong>Upload a Image:</strong>
        <input type="file" name="the_file" id="fileToUpload" required>
        </div>
 <br>
         <button type="submit" name="submit" class="btn btn-default">UPLOAD</button>
      </form>
      </div>
</div>
</div>
</body>
</html>
