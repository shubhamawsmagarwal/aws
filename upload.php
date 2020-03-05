<?php
	require './vendor/autoload.php';
	use Aws\S3\S3Client;
	use Aws\S3\Exception\S3Exception;

	// AWS Info
	$bucketName = 'myprojectstorage1107';
	$IAM_KEY = 'AKIARDXNA5EGCKKTRFVY';
	$IAM_SECRET = '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';

	// Connect to AWS
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
	} catch (Exception $e) {
		die("Error: " . $e->getMessage());
	}

	//test_example is folder name
	//keyname is path of file inside s3
	$keyName = 'test_example/' . basename($_FILES["fileToUpload"]['name']);
	$pathInS3 = 'https://s3.us-east-1.amazonaws.com/' . $bucketName . '/' . $keyName;

	// Add it to S3
	try {
		$file = $_FILES["fileToUpload"]['tmp_name'];

		$s3->putObject(
			array(
				'Bucket'=>$bucketName,
				'Key' =>  $keyName,
				'SourceFile' => $file,
				'StorageClass' => 'REDUCED_REDUNDANCY'
			)
		);

	} catch (S3Exception $e) {
		die('Error:' . $e->getMessage());
	} catch (Exception $e) {
		die('Error:' . $e->getMessage());
	}

    //add to database
    $accessCode=$_POST['accessCode'];
    @mysql_connect('localhost','s3user','s3users3') or die("error connecting to database server");
    @mysql_select_db('s3database') or die("error connecting to database");
    $query="INSERT INTO `s3table`(`S3FilePath`, `accessCode`) VALUES ('$keyName','$accessCode')";
    $query_run=mysql_query($query);
    
	echo 'Done';
?>