example-php-socket.io-notification
==================================

PHPサーバとSocket.ioサーバでセッション共有

PHP-Ajax経由でチャットメッセージの送信

Websocketsで直接チャットメッセージの送信

を行うテスト

Pub/Subを利用しているので複数のNodeインスタンスを利用しても同じ動きになるように作られています.

# 環境

- nginx
- PHP 5.6.x
- PhalconPHP 1.3.x
- apcu 4.0.8
- phpredis 2.2.7
- msgpack 0.5.6
- nodejs 0.12.x
- redis

# PHP設定

セッションデータのシリアライズにmsgpack

セッションデータの保存にredisを利用

以下設定を適用してください.

```txt
session.serialize_handler=msgpack
session.save_handler = redis
session.save_path = "tcp://127.0.0.1:6379?weight=1"
```
