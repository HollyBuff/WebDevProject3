<?php
//DB details
$dbHost = 'localhost';
$dbUsername = 'root';
$dbPassword = '';
$dbName = 'webdev_project2';


//Create connection and select DB
$connect = new mysqli($dbHost, $dbUsername, $dbPassword, $dbName);

if ($connect->connect_error) {
    die("Unable to connect database: " . $connect->connect_error);
}

else {
	function doStuff() {
	  static $cache = null;

	  if ($cache === null) {
	     $cache = " Drop TABLE if exists members;
	     	 CREATE TABLE `members` (
			 `id` int(11) NOT NULL AUTO_INCREMENT,
			 `name` varchar(100) COLLATE utf8_unicode_ci NOT NULL,
			 `email` varchar(100) COLLATE utf8_unicode_ci NOT NULL,
			 `phone` varchar(15) COLLATE utf8_unicode_ci NOT NULL,
			 `created` datetime NOT NULL,
			 `modified` datetime NOT NULL,
			 `status` enum('1','0') COLLATE utf8_unicode_ci NOT NULL DEFAULT '1',
			 PRIMARY KEY (`id`)
			) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci";
			 if ($connect->query($cache) === TRUE) {
			    echo "Table MyGuests created successfully";
			} else {
			    echo "Error creating table: " . $connect->error;
			}
	  }
	  else {
	  	"csv already up to date";
	  }

	  // code using $cache
	}
}

