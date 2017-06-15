#!/usr/bin/php
<?php
	include 'database.php';

	try
	{
		$pdo = new PDO($DB_DSN, $DB_USER, $DB_PASSWORD);
		$pdo->exec("DROP DATABASE IF EXISTS ".$DB_NAME);
		$DATABASE = $pdo->exec("CREATE DATABASE IF NOT EXISTS ".$DB_NAME);
		if ($DATABASE)
		{
			echo "Database : ".$DB_NAME." created".PHP_EOL;
		}
		else
		{
			die(print_r($pdo->errorInfo(), true));
		}
		$pdo = null;
	}
	catch(PDOException $e)
	{
		die("DB ERROR: ". $e->getMessage());
	}
	try
	{
		$DB_DSNNAME = $DB_DSN.";dbname=".$DB_NAME;
		$pdo = new PDO($DB_DSNNAME , $DB_USER, $DB_PASSWORD);
	}
	catch(PDOException $e)
	{
		die("DB ERROR: ". $e->getMessage());
	}
	echo '========================================'.PHP_EOL;
	//create user table;
	$query = "DROP TABLE IF EXISTS ".$DB_TABLE['user'];
	$pdo->exec($query);
	$query = "CREATE TABLE IF NOT EXISTS ".$DB_TABLE['user']."(id int(11) NOT NULL AUTO_INCREMENT PRIMARY KEY, login varchar(255) UNIQUE NOT NULL, email varchar(255) UNIQUE NOT NULL , password varchar(255) NOT NULL, confirmed BOOLEAN NOT NULL DEFAULT 0, confirm varchar(255), reset varchar(255));";
	$pdo->exec($query);
	echo "Tables: ".$DB_TABLE['user']." created".PHP_EOL;

	$pdo->query("INSERT INTO ".$DB_TABLE['user']."(login, email, password, confirmed) VALUES('mzane', 'mzane@student.42.fr', '556d2b9302a8b0757d4b9bcece4f640f385037d775f59901e9174f9700fd89e108f1d869720b511022de1020b4f19340a3f3af9c7ffd0abb31d041f119ab11ab', '1')");
	echo "Create User Owner (mzane)".PHP_EOL;

	//create image table;

	$query = "DROP TABLE IF EXISTS ".$DB_TABLE['image'];
	$pdo->exec($query);
	$query = "CREATE TABLE IF NOT EXISTS ".$DB_TABLE['image']."(id int(11) NOT NULL AUTO_INCREMENT PRIMARY KEY, url_link TEXT NOT NULL, creation_date DATETIME NOT NULL, user_id int(11) NOT NULL);";
	$pdo->exec($query);
	echo "Tables: ".$DB_TABLE['image']." created".PHP_EOL;


	// create comment table;

	$query = "DROP TABLE IF EXISTS ".$DB_TABLE['comment_image'];
	$pdo->exec($query);
	$query = "CREATE TABLE IF NOT EXISTS ".$DB_TABLE['comment_image']."(id int(11) NOT NULL AUTO_INCREMENT PRIMARY KEY, content TEXT NOT NULL, image_id int(11) NOT NULL, user_id int(11) NOT NULL);";
	$pdo->exec($query);
	echo "Tables: ".$DB_TABLE['comment_image']." created".PHP_EOL;

	// create like table;

	$query = "DROP TABLE IF EXISTS ".$DB_TABLE['like_image'];
	$pdo->exec($query);
	$query = "CREATE TABLE IF NOT EXISTS ".$DB_TABLE['like_image']."(id int(11) NOT NULL AUTO_INCREMENT PRIMARY KEY, image_id int(11) NOT NULL, user_id int(11) NOT NULL);";
	$pdo->exec($query);
	echo "Tables: ".$DB_TABLE['like_image']." created".PHP_EOL;

	echo '========================================'.PHP_EOL;

	// Index for table comment_image
	$query = "ALTER TABLE `comment_image` ADD KEY `user_id` (`user_id`), ADD KEY `image_id` (`image_id`);";
	$pdo->exec($query);
	echo "Indexes for table ".$DB_TABLE['comment_image'].PHP_EOL;

	// index for table image
	$query = "ALTER TABLE `image` ADD KEY `user_id` (`user_id`);";
	$pdo->exec($query);
	echo "Indexes for table ".$DB_TABLE['image'].PHP_EOL;

	// Index for table like_image
	$query = "ALTER TABLE `like_image` ADD KEY `user_id` (`user_id`), ADD KEY `image_id` (`image_id`);";
	$pdo->exec($query);
	echo "Indexes for table ".$DB_TABLE['like_image'].PHP_EOL;

	echo '========================================'.PHP_EOL;
	// Constraints for table `comment_image`
	$query = "ALTER TABLE `comment_image` ADD CONSTRAINT `comment_image_ibfk_1` FOREIGN KEY (`user_id`) REFERENCES `user` (`id`) ON DELETE CASCADE ON UPDATE CASCADE, ADD CONSTRAINT `comment_image_ibfk_2` FOREIGN KEY (`image_id`) REFERENCES `image` (`id`) ON DELETE CASCADE ON UPDATE CASCADE;";
	$pdo->exec($query);
	echo "Constraints for table ".$DB_TABLE['comment_image'].PHP_EOL;

	// Constraints for table `image`
	$query = "ALTER TABLE `image` ADD CONSTRAINT `image_ibfk_1` FOREIGN KEY (`user_id`) REFERENCES `user` (`id`) ON DELETE CASCADE ON UPDATE CASCADE;";
	$pdo->exec($query);
	echo "Constraints for table ".$DB_TABLE['image'].PHP_EOL;

	// Constraints for table `like_image`
	$query = "ALTER TABLE `like_image` ADD CONSTRAINT `like_image_ibfk_1` FOREIGN KEY (`user_id`) REFERENCES `user` (`id`) ON DELETE CASCADE ON UPDATE CASCADE, ADD CONSTRAINT `like_image_ibfk_2` FOREIGN KEY (`image_id`) REFERENCES `image` (`id`) ON DELETE CASCADE ON UPDATE CASCADE;";
	$pdo->exec($query);
	echo "Constraints for table ".$DB_TABLE['like_image'].PHP_EOL;
	if (!file_exists('/uploads')) {
		mkdir('/uploads', 0775, true);
	}
	$pdo = null;



?>
