SELECT * 
FROM songs
WHERE songname LIKE :term
OR artist LIKE :term