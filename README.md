## CakePHP With Socket.IO Example
=======================

### REQUIREMENTS
* MySQL
* NodeJS



### Install Directions
	npm install socket.io mysql 
	node server.js (server.js is located in root)


### Execute this SQL
	CREATE TABLE events (
		id int auto_increment primary key,
		scheduled_date datetime,
		name varchar(50)
	)


### License
Unless otherwise noted, all files contained within this project are liensed
under the MIT opensource license. See the included file LICENSE or visit
[opensource.org][] for more information.

[opensource.org]: http://opensource.org/licenses/MIT
