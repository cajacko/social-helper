import socketIo from 'socket.io'
import fs from 'fs'
import express from 'express'
import http from 'http'
import bodyParser from 'body-parser';

var app = express()
var server = http.Server(app);
var io = socketIo(server)

app.use(express.static(__dirname + '/public'))

app.use(bodyParser.json())

const defaultState = {
  player1: false,
  player2: false,
  game: false,
  score: [[false, false, false], [false, false, false], [false, false, false]],
  turn: false
}

var state = defaultState

app.get('/', function (req, res) {
  fs.readFile(__dirname + '/public/index.html', function(err, data) {
    if (err) {
      res.writeHead(500)
      return res.end('Error loading index.html')
    }

    res.writeHead(200)
    res.end(data)
  })
})

io.on('connection', function (socket) {
  socket.emit('getState', state)

  app.all('/getState', function (req, res) {
    res.json(state)
  })

  app.all('/setState', function (req, res) {
    state = req.body
    console.log('setState', state)
    socket.emit('getState', state)
    res.json(state)
  })

  app.all('/reset', function (req, res) {
    console.log('reset')
    state = defaultState
    socket.emit('getState', state)
    res.json(state)
  })
})

server.listen(1337, function () {
  console.log('Example app listening on port 1337!')
})
