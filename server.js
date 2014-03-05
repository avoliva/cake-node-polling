var io                  = require('socket.io').listen(8081),
    mysql               = require('mysql'),
    connectionsArray    = [],
    connection          = mysql.createConnection({
        host        : 'localhost',
        user        : 'root',
        password    : 'root',
        database    : 'test',
        port        : 3306
    }),
    POLLING_INTERVAL = 3000,
    pollingTimer;

// If there is an error connecting to the database
connection.connect(function(err) {
  // connected! (unless `err` is set)
  console.log( err );
});


/*
*
* HERE IT IS THE COOL PART
* This function loops on itself since there are sockets connected to the page
* sending the result of the database query after a constant interval
*
*/
var pollingLoop = function () {
   
    // Make the database query
    var query = connection.query('SELECT * FROM events WHERE events.scheduled_date BETWEEN DATE_SUB(CURDATE(), INTERVAL 1 DAY) AND NOW() ORDER BY ID ASC'),
        dat = []; // this array will contain the result of our db query


    // set up the query listeners
    query
    .on('error', function(err) {
        // Handle error, and 'end' event will be emitted after this as well
        console.log( err );
        updateSockets( err );
       
    })
    .on('result', function( user ) {
        // it fills our array looping on each user row inside the db
        dat.push( user );
    })
    .on('end',function(){
        // loop on itself only if there are sockets still connected
        if(connectionsArray.length) {
            pollingTimer = setTimeout( pollingLoop, POLLING_INTERVAL );

            updateSockets({dat:dat});
        }
    });

};

// create a new websocket connection to keep the content updated without any AJAX request
io.sockets.on( 'connection', function ( socket ) {
   
    console.log('Number of connections:' + connectionsArray.length);
    // start the polling loop only if at least there is one user connected
    if (!connectionsArray.length) {
        pollingLoop();
    }
   
    socket.on('disconnect', function () {
        var socketIndex = connectionsArray.indexOf( socket );
        console.log('socket = ' + socketIndex + ' disconnected');
        if (socketIndex >= 0) {
            connectionsArray.splice( socketIndex, 1 );
        }
    });

    console.log( 'A new socket is connected!' );
    connectionsArray.push( socket );
   
});

var updateSockets = function ( data ) {
    // store the time of the latest update
    data.time = new Date();
    // send new data to all the sockets connected
    connectionsArray.forEach(function( tmpSocket ){
        tmpSocket.volatile.emit( 'notification' , data );
    });
};
