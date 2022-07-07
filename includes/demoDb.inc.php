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
	rating VARCHAR(50),
	PRIMARY KEY(bnum)
);

INSERT INTO Blogs
	(subject, text, rating, created) 
VALUES
	("FirstPost", "Lorem ipsum dolor sit amet consectetur, adipisicing elit. Cumque tenetur officia fugiat ipsam hic mollitia consectetur explicabo saepe aspernatur et, deleniti minus numquam earum similique quasi eligendi, corporis nostrum magni?", "13425", ' . time() . '),
    ("SecondPost", "Lorem ipsum dolor sit amet consectetur, adipisicing elit. Cumque tenetur officia fugiat ipsam hic mollitia consectetur explicabo saepe aspernatur et, deleniti minus numquam earum similique quasi eligendi, corporis nostrum magni?", "31341342123", ' . time() . '),
    ("ThirdPost", "Lorem ipsum dolor sit amet consectetur, adipisicing elit. Cumque tenetur officia fugiat ipsam hic mollitia consectetur explicabo saepe aspernatur et, deleniti minus numquam earum similique quasi eligendi, corporis nostrum magni?", "1245", ' . time() . ');
	
CREATE TABLE Admins (
	user VARCHAR(50),
	pwd VARCHAR(255),
	PRIMARY KEY(user)
);

INSERT INTO Admins
	(user, pwd)
VALUES
	("admin","' . password_hash('admin', PASSWORD_DEFAULT) . '"),
	("ryan","' . password_hash('ryan', PASSWORD_DEFAULT) . '");


CREATE TABLE Users (
	user VARCHAR(50),
	pwd VARCHAR(255),
	PRIMARY KEY(user)
);

';



$db->exec($sql);






echo 'Datenbank "fa111" mit der Tabelle "Blog" wurde erstellt';
