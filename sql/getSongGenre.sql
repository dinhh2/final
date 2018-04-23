SELECT * 
FROM song_genre
JOIN genre on song_genre.genreid = genre.genreid
WHERE songid = :songid