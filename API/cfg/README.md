API/cfg
===
 - All files with the .conf extensions will be parsed
 - All duplicate keys will be OVERWRITTEN by the last file alphabetically
 	- a.key = 1
 	- b.key = 2
 	- z.key = 3
 	- Will yield key (3)
 
