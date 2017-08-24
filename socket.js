var server = require('http').Server();

var io = require('socket.io')(server);

var Redis = require('ioredis');
var redis = new Redis();

redis.subscribe('new-posts');

redis.on('message', function (channel, message) {
    message = JSON.parse(message);

    io.emit(channel + ':heading.' + message.heading_id, message);
});

server.listen(3000);