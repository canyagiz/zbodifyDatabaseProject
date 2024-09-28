create database zbodify;
use zbodify;

CREATE TABLE USER(
User_Id			INT 			AUTO_INCREMENT PRIMARY KEY,
username		varchar(20)		NOT NULL,
Umail			varchar(254)	NOT NULL,
Upassword		varchar(50)		NOT NULL,

CONSTRAINT
UNIQUE (Umail)
); 

CREATE TABLE ARTIST(
Artist_Id		INT 			AUTO_INCREMENT PRIMARY KEY,
Arname			varchar(30)		NOT NULL,
AruserId		INT				NOT NULL,
Arstyle			varchar(20)		NOT NULL,
Arcountry		varchar(20),
ArfavCount 		int,
AralbumCount 	varchar(4),

CONSTRAINT
FOREIGN KEY (AruserId) REFERENCES USER(User_Id) ON DELETE CASCADE

);

#III. Album Table: 
CREATE TABLE ALBUM(
	Album_Id      	INT 			 AUTO_INCREMENT PRIMARY KEY,
  	AlartistId		INT	 			 NOT NULL, 
  	Alname        	varchar(20)      NOT NULL,
  	Algenre       	varchar(20)   	 NOT NULL,
  	AlpublishDate   DATE          	 NOT NULL,
    AlImagePath		varchar(260)	 NOT NULL,

CONSTRAINT 
FOREIGN KEY (AlartistId) REFERENCES ARTIST(Artist_Id) ON DELETE CASCADE
);

#IV. Song Table:
CREATE TABLE SONG(
  Song_Id      		INT 			AUTO_INCREMENT PRIMARY KEY,
  Sname        		varchar(50)   	NOT NULL,
  Sduration    	    int         	NOT NULL,
  SalbumId      	INT 			NOT NULL,
  SongPath			varchar(260)	NOT NULL,	#Max file path length is 260, for Windows
  SongImagePath		varchar(260)	NOT NULL,	
  
 	 CONSTRAINT
  FOREIGN KEY (SalbumId) REFERENCES ALBUM(Album_Id) ON DELETE CASCADE
);




#V. Playlist Table:
CREATE TABLE PLAYLIST(
	Playlist_Id 		INT 				AUTO_INCREMENT PRIMARY KEY,
  	Plname				varchar(50) 		NOT NULL,
  	Pldescription		varchar(255),
  	PLuserId			INT 				NOT NULL,
    PlImagePath		    varchar(260)   		NOT NULL,

 	 CONSTRAINT
  FOREIGN KEY (PluserId) REFERENCES USER(User_Id) ON DELETE CASCADE
);

select * from song;


#VI. Membership Table:
CREATE TABLE MEMBERSHIP(
 Mtype	   varchar(15)    NOT NULL,
 Mcost	   varchar(6)	  NOT NULL,
    
  CONSTRAINT
  PRIMARY KEY (Mtype)
);



#VII. Payment Table: 
CREATE TABLE PAYMENT(
	PAYM_UserId	    	INT 				NOT NULL,
	PAYM_name			varchar(15)			DEFAULT NULL,
  	PAYM_CC_fname		varchar(20) 		NOT NULL,
	PAYM_CC_mname		varchar(20),
	PAYM_CC_lname		varchar(20) 		NOT NULL,
  	PAYM_CC_number 		char(16)			NOT NULL,
  	PAYM_CC_date		char(5)				NOT NULL,
  	PAYM_CC_CVV			char(3)				NOT NULL,
    
    CONSTRAINT
    FOREIGN KEY (PAYM_UserId) REFERENCES USER(user_Id) ON DELETE CASCADE
);

#VIII. Paying Table:
CREATE TABLE PAYING(
	PAYuserId			INT				NOT NULL,
 	PAYmtype			varchar(10)		NOT NULL,
	PAYisPaid 			boolean 		NOT NULL,
	PAYdate 			date 			NOT NULL,
	CONSTRAINT
  FOREIGN KEY (PAYuserId) REFERENCES USER(User_Id) ON DELETE CASCADE,
    CONSTRAINT
  FOREIGN KEY (PAYmtype) REFERENCES MEMBERSHIP(Mtype) ON DELETE CASCADE
);

#IX. Listen Table:
CREATE TABLE LISTEN(
	LuserId		INT		NOT NULL,
  	LsongId		INT		NOT NULL,
  
 	 CONSTRAINT
  FOREIGN KEY (LuserId) REFERENCES USER(User_Id),
  CONSTRAINT
  FOREIGN KEY (LsongId) REFERENCES SONG(Song_Id) ON DELETE CASCADE
);


#X. Last Listened Table:
CREATE TABLE LAST_LISTENED(
	LastUserId		INT		NOT NULL PRIMARY KEY,
  	LastSongId		INT		NOT NULL,
  
 	 CONSTRAINT
  FOREIGN KEY (LastUserId) REFERENCES USER(User_Id),
  CONSTRAINT
  FOREIGN KEY (LastSongId) REFERENCES SONG(Song_Id) ON DELETE CASCADE
);

-- Create the trigger to log user listening activity before INSERT
DELIMITER //

CREATE TRIGGER before_insert_listen_trigger
BEFORE INSERT ON LISTEN
FOR EACH ROW
BEGIN
    -- Insert the new song ID into the LAST_LISTENED table
    INSERT INTO LAST_LISTENED (LastUserId, LastSongId)
    VALUES (NEW.LuserId, NEW.LsongId)
    ON DUPLICATE KEY UPDATE
    LastSongId = NEW.LsongId;
END;
//

DELIMITER ;


-- Create the trigger to log user listening activity before UPDATE
DELIMITER //

CREATE TRIGGER before_update_listen_trigger
BEFORE UPDATE ON LISTEN
FOR EACH ROW
BEGIN
    DECLARE prev_song_id INT;

    -- Retrieve the previous song ID before update
    SET prev_song_id = OLD.LsongId;

    -- Insert the previous song ID into the LAST_LISTENED table
    INSERT INTO LAST_LISTENED (LastUserId, LastSongId)
    VALUES (NEW.LuserId, prev_song_id)
    ON DUPLICATE KEY UPDATE
    LastSongId = prev_song_id;
END;
//

DELIMITER ;

#XI. Contain Table:
CREATE TABLE CONTAIN(
	CONPl_Id	INT		NOT NULL,
  	CONSong_Id	INT		NOT NULL,
CONSTRAINT
  FOREIGN KEY (CONPl_Id) REFERENCES PLAYLIST(Playlist_Id) ON DELETE CASCADE,
  	CONSTRAINT
  FOREIGN KEY (CONSong_Id) REFERENCES SONG(Song_Id) ON DELETE CASCADE,
  CONSTRAINT 
  unique_playlist_song UNIQUE (CONPl_Id, CONSong_Id)
);


CREATE VIEW User_Playlist_Song_Count AS
SELECT P.Playlist_Id, P.Plname, COUNT(C.CONSong_Id) AS Song_Count
FROM PLAYLIST P
LEFT JOIN CONTAIN C ON P.Playlist_Id = C.CONPl_Id
GROUP BY P.Playlist_Id, P.Plname;

CREATE VIEW User_Playlist_Count AS
SELECT U.User_Id, U.username, COUNT(P.Playlist_Id) AS Playlist_Count
FROM USER U
LEFT JOIN PLAYLIST P ON U.User_Id = P.PLuserId
GROUP BY U.User_Id, U.username;

select * from User_Playlist_Count;
select * from Artist_Album_Count;

CREATE VIEW Artist_Album_Count AS
SELECT A.Artist_Id, A.Arname, COUNT(AL.Album_Id) AS Album_Count
FROM ARTIST A
LEFT JOIN ALBUM AL ON A.Artist_Id = AL.AlartistId
GROUP BY A.Artist_Id, A.Arname;

CREATE VIEW Album_Song_Count AS
SELECT AL.Album_Id, AL.Alname, COUNT(S.Song_Id) AS Song_Count
FROM ALBUM AL
LEFT JOIN SONG S ON AL.Album_Id = S.SalbumId
GROUP BY AL.Album_Id, AL.Alname;


-- Create a trigger to update the album count in the Artist table
DELIMITER //

CREATE TRIGGER album_insertion_trigger AFTER INSERT ON ALBUM
FOR EACH ROW
BEGIN
    UPDATE ARTIST
    SET AralbumCount = AralbumCount + 1
    WHERE Artist_Id = NEW.AlartistId;
END;
//

DELIMITER ;

-- Create a trigger to update the album count in the Artist table upon deletion
DELIMITER //

CREATE TRIGGER album_delete_trigger AFTER DELETE ON ALBUM
FOR EACH ROW
BEGIN
    UPDATE ARTIST
    SET AralbumCount = AralbumCount - 1
    WHERE Artist_Id = OLD.AlartistId;
END;
//

DELIMITER ;

CREATE VIEW AlbumTotalDuration AS
SELECT a.Album_Id, a.Alname, SUM(s.Sduration) AS TotalDuration
FROM ALBUM a
INNER JOIN SONG s ON a.Album_Id = s.SalbumId
GROUP BY a.Album_Id, a.Alname;

CREATE VIEW PlaylistTotalDuration AS
SELECT c.CONPl_Id, SUM(s.Sduration) AS TotalDuration
FROM CONTAIN c join song s on (c.CONSong_Id = s.Song_Id)
GROUP BY c.CONPl_Id;


CREATE INDEX idx_User_Umail ON USER(Umail);
CREATE INDEX idx_Playlist_PLuserId ON PLAYLIST(PLuserId);
CREATE INDEX idx_Song_SalbumId ON SONG(SalbumId);

insert into membership(Mtype,Mcost)
values ("Standard", "5.00"),
("Premium","10.00");



