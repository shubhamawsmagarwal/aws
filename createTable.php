<?php
  @mysql_connect('localhost','s3user','s3users3') or die("error connecting to database server");
  @mysql_select_db('s3database') or die("error connecting to database");
  $query="CREATE TABLE `s3table` ( `id` INT NOT NULL AUTO_INCREMENT , `S3FilePath` VARCHAR(250) NULL DEFAULT NULL , `accessCode` VARCHAR(250) NULL DEFAULT NULL , PRIMARY KEY (`id`))";
  $query_run=mysql_query($query);
  echo 'Done';
?>