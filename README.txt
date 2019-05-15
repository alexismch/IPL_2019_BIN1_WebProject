There is two steps to follow to active the website...
0) Copy past the project in C:/Progs/wamp64/www/



1) Import database : 
	- Go to 127.0.0.1/phpmyadmin
	- Go to section "Importer"
	- Click on "choisir un fichier", choose file which is at /models/db.sql and execute
	- Go to "class_not_found" database section
	- Go to section "Importer"
	- Click on "choisir un fichier", choose fil which is at /models/data.sql, uncheck "Activer la vérification des clés étrangères" and execute

2) Create vhost