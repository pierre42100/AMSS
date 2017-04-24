CREATE TABLE `db_mails` (
	`num`	INTEGER PRIMARY KEY AUTOINCREMENT,
	`id`	TEXT,
	`creation_date`	TEXT,
	`from_name`	TEXT,
	`from_mail`	TEXT,
	`subject`	TEXT,
	`message`	TEXT,
	`send_date`	TEXT,
	`send_time`	TEXT,
	`planned`	INTEGER DEFAULT 0,
	`send_timestamp`	INTEGER,
	`destination_mail`	TEXT
);

