<?php

require_once './PDOConnect.inc.php';


$sql = 'DROP DATABASE IF EXISTS fa111;
CREATE DATABASE fa111;
	
USE fa111;

CREATE TABLE Blogs (
	bnum INTEGER AUTO_INCREMENT,
	hidden BOOLEAN,
	subject VARCHAR(50),
	text TEXT,
	created INTEGER,
	PRIMARY KEY(bnum)
);

INSERT INTO Blogs
	(HIDDEN, subject, text, created) 
VALUES
	(0, "FirstPost", "1 Lorem ipsum dolor sit amet consectetur, adipisicing elit. Cumque tenetur officia fugiat ipsam hic mollitia consectetur explicabo saepe aspernatur et, deleniti minus numquam earum similique quasi eligendi, corporis nostrum magni?", ' . time() . '),
    (0, "SecondPost", "2 Lorem ipsum dolor sit amet consectetur, adipisicing elit. Cumque tenetur officia fugiat ipsam hic mollitia consectetur explicabo saepe aspernatur et, deleniti minus numquam earum similique quasi eligendi, corporis nostrum magni?", ' . time() . '),
    (0, "ThirdPost", "3 Lorem ipsum dolor sit amet consectetur, adipisicing elit. Cumque tenetur officia fugiat ipsam hic mollitia consectetur explicabo saepe aspernatur et, deleniti minus numquam earum similique quasi eligendi, corporis nostrum magni?", ' . time() . '),
	(1, "FourthPost", "4 Lorem ipsum dolor sit amet consectetur, adipisicing elit. Cumque tenetur officia fugiat ipsam hic mollitia consectetur explicabo saepe aspernatur et, deleniti minus numquam earum similique quasi eligendi, corporis nostrum magni?", ' . time() . ');
	

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
	(3, "Second comment on third blog", "admin", ' . time() . ');


CREATE TABLE Ratings (
	rnum INTEGER AUTO_INCREMENT,
	bnum INTEGER,
	user VARCHAR(50),
	rating INTEGER,
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

