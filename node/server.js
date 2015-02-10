// 環境変数から設定情報を読み出す
var SOCKET_IO_PORT = process.env.SOCKET_IO_PORT || 3000;
var REDIS_SESSION_HOST = process.env.REDIS_HOST || '127.0.0.1';
var REDIS_SESSION_PORT = process.env.REDIS_PORT || 6379;
var REDIS_SESSION_AUTH = process.env.REDIS_AUTH || null;
var REDIS_PUB_HOST = process.env.REDIS_HOST || '127.0.0.1';
var REDIS_PUB_PORT = process.env.REDIS_PORT || 6379;
var REDIS_PUB_AUTH = process.env.REDIS_AUTH || null;
var REDIS_SUB_HOST = process.env.REDIS_HOST || '127.0.0.1';
var REDIS_SUB_PORT = process.env.REDIS_PORT || 6379;
var REDIS_SUB_AUTH = process.env.REDIS_AUTH || null;

// imports
var http = require('http'),
    socketIo = require('socket.io'),
    fs = require('fs'),
    redis = require('redis'),
    socketIoRedisAdapter = require('socket.io-redis'),
    msgpack = require('msgpack');

// セッション用Redisへ接続
var redisSessionClient;
if (REDIS_SESSION_AUTH != null) {
    redisSessionClient = redis.createClient(REDIS_SESSION_PORT, REDIS_SESSION_HOST, {detect_buffers:true, auth_pass:REDIS_SESSION_AUTH});
} else {
    redisSessionClient = redis.createClient(REDIS_SESSION_PORT, REDIS_SESSION_HOST, {detect_buffers:true});
}

// Pub/SubのPub用Redisへ接続
var pubRedisClient;
if (REDIS_PUB_AUTH != null ) {
    pubRedisClient = redis.createClient(REDIS_PUB_PORT, REDIS_PUB_HOST, {detect_buffers:true, auth_pass:REDIS_PUB_AUTH});
} else {
    pubRedisClient = redis.createClient(REDIS_PUB_PORT, REDIS_PUB_HOST, {detect_buffers:true});
}

// Pub/SubのSub用Redisへ接続
var subRedisClient;
if (REDIS_SUB_AUTH != null ) {
    subRedisClient = redis.createClient(REDIS_SUB_PORT, REDIS_SUB_HOST, {detect_buffers:true, auth_pass:REDIS_SUB_AUTH});
} else {
    subRedisClient = redis.createClient(REDIS_SUB_PORT, REDIS_SUB_HOST, {detect_buffers:true});
}

// HTTPサーバ
var app = http.createServer(function (req, res) {
    fs.readFile(__dirname + '/index.html',
        function (err, data) {
            if (err) {
                res.writeHead(500);
                return res.end('Error loading index.html');
            }
            res.writeHead(200);
            res.end(data);
        }
    );
});

// Socket.ioサーバ
app.listen(SOCKET_IO_PORT);
var io = socketIo(app);
io.adapter(socketIoRedisAdapter({pubClient:pubRedisClient, subClient:subRedisClient}));

// socket.io認証周り
io.use(function (socket, next) {
    var cookie = require('cookie').parse(socket.request.headers.cookie);
    // TODO: cookieにPHPREDIS_SESSIONが存在するか
    // TODO: 取得したセッションデータをsocket.ioのセッションへ格納
    redisSessionClient.get(new Buffer('PHPREDIS_SESSION:' + cookie['PHPSESSID']), function (err, buf) {
        var session = msgpack.unpack(buf);
        if (session['ses-user-id'] != undefined && session['ses-username'] != undefined) {
            socket.username = session['ses-username'];
            socket.userId = session['ses-user-id'];
            next();
        } else {
            // セッション情報にユーザ情報が含まれていない
            next(new Error('401 Unauthorized'));
        }
    });
});

io.on('connection', function (socket) {
    io.sockets.emit('join', { sId: socket.id, userId: socket.userId, username: socket.username }); // 全員へ送る

    socket.on('chat', function (message) {
        console.log('event: chat');
        console.log(message);
        io.sockets.emit('chat', {userId: socket.userId, username: socket.username, message: message})
    });

    socket.on('debug', function (data) {
        console.log('event: debug');
        console.log(data);
    });

    socket.on('disconnect', function () {
        io.sockets.emit('leave', {sId: socket.id, userId: socket.userId, username: socket.username})
    });
});



