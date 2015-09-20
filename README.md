# API

The public facing API

Install
=====

 - Install the latest version of vagrant http://www.vagrantup.com/downloads
 - Install VirtualBox https://www.virtualbox.org/wiki/Downloads
 - Update your vagrant repos `vagrant box update`
 - You might have to log out and log back in
 - On the CLIENT create a directory called `~/vm-share` 
 - This will automatically be synced to `/workspace` on the HOST
 - `vagrant up` to build the development environment
 - Select an interface with internet access (Probably 1)
 - Grab a cup of coffee - this takes a while
 - `vagrant ssh` to access the server
 
Request Life Cycle
=====
 - Single include in /app for all the endpoints
 - Include will 
 	- Determine body type
 	- Load meta
 	- Auth
 	- Build request object
 	- Process request object
 	- Encode response object
 	- Return response string
 - Log transaction