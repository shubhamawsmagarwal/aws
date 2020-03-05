<?php

  require './vendor/autoload.php';
  use Aws\S3\S3Client;
  use Aws\S3\Exception\S3Exception;
  
  // AWS Info
  $bucketName = 'myprojectstorage1107';
  $IAM_KEY = 'AKIARDXNA5EGCKKTRFVY';
  $IAM_SECRET = '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';


  // Connect to database
  $accessCode = $_GET['c'];
  @mysql_connect('localhost','s3user','s3users3') or die("error connecting to database server");
  @mysql_select_db('s3database') or die("error connecting to database");
  $query="SELECT * FROM `s3table` WHERE `accessCode`='$accessCode'";
  $query_run=mysql_query($query);

  if (mysql_num_rows($query_run) != 1) {
    die("Error: Invalid access code");
  }
  
  // Get path from db
  $keyPath = '';
  while($row = mysql_fetch_assoc($query_run)) {
    $keyPath = $row['S3FilePath'];
  }

  // Get file
  try {
    $s3 = S3Client::factory(
      array(
        'credentials' => array(
          'key' => $IAM_KEY,
          'secret' => $IAM_SECRET
        ),
        'version' => 'latest',
        'region'  => 'us-east-1'
      )
    );

    $result = $s3->getObject(array(
      'Bucket' => $bucketName,
      'Key'    => $keyPath
    ));


    // Display it in the browser
    header("Content-Type: {$result['ContentType']}");
    header('Content-Disposition: filename="' . basename($keyPath) . '"');
    echo $result['Body'];

  } catch (Exception $e) {
    die("Error: " . $e->getMessage());
  }
?>