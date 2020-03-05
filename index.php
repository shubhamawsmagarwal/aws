<!DOCTYPE html>
<html>
<body>

<form action="upload.php" method="post" enctype="multipart/form-data">
    Select file to upload:
    <input type="file" name="fileToUpload">
    <input type="text" name="accessCode" placeholder="choose a access code" required>
    <input type="submit" value="Upload file">
</form>

</body>
</html>