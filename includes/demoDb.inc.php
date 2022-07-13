<?php

require_once './PDOConnect.inc.php';


$sql = 'DROP DATABASE IF EXISTS fa111;
CREATE DATABASE fa111;
	
USE fa111;

CREATE TABLE Blogs (
	bnum INTEGER AUTO_INCREMENT,
	subject VARCHAR(50),
	text TEXT,
	created INTEGER,
	rating DECIMAL(8,1),
	ratingCount INTEGER,
	PRIMARY KEY(bnum)
);

INSERT INTO Blogs
	(subject, text, rating, ratingCount, created) 
VALUES
	("FirstPost", "Lorem ipsum dolor sit amet consectetur, adipisicing elit. Cumque tenetur officia fugiat ipsam hic mollitia consectetur explicabo saepe aspernatur et, deleniti minus numquam earum similique quasi eligendi, corporis nostrum magni?", "4.5", "3", ' . time() . '),
    ("SecondPost", "Lorem ipsum dolor sit amet consectetur, adipisicing elit. Cumque tenetur officia fugiat ipsam hic mollitia consectetur explicabo saepe aspernatur et, deleniti minus numquam earum similique quasi eligendi, corporis nostrum magni?", "1", "2", ' . time() . '),
    ("ThirdPost", "Lorem ipsum dolor sit amet consectetur, adipisicing elit. Cumque tenetur officia fugiat ipsam hic mollitia consectetur explicabo saepe aspernatur et, deleniti minus numquam earum similique quasi eligendi, corporis nostrum magni?", "2", "2", ' . time() . ');
	

CREATE TABLE Users (
	user VARCHAR(50),
	pwd VARCHAR(255),
	admin BOOLEAN,
	PRIMARY KEY(user)
);

INSERT INTO Users
	(user, pwd , admin)
VALUES
	("admin","' . password_hash('admin', PASSWORD_DEFAULT) . '", "1"),
	("user","' . password_hash('user', PASSWORD_DEFAULT) . '", "0");




CREATE TABLE Comments (
	cnum INTEGER AUTO_INCREMENT,
	blogNum INTEGER,
	text TEXT,
	user VARCHAR(50),
	created INTEGER,
	PRIMARY KEY(cnum)
);

INSERT INTO Comments
	(blogNum, text, user, created)
VALUES
	(1, "Comment on first blog", "user", ' . time() . '),
	(3, "First comment on third blog", "user", ' . time() . '),
	(3, "Second comment on third blog", "user", ' . time() . ');


CREATE TABLE Ratings (
	rnum INTEGER AUTO_INCREMENT,
	bnum INTEGER,
	user VARCHAR(50),
	rating DECIMAL(8,1),
	PRIMARY KEY(rnum)
);

INSERT INTO Ratings
	(bnum, user, rating)
VALUES
	(1, "Ryan", "5"),
	(2, "Alaa", "1"),
	(3, "Hacker", "1"),
	(3, "Test", "5");
';



$db->exec($sql);






header('Location: ../index.php');
exit;
?>

