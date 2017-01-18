import fs from 'fs'
import express from 'express'
import http from 'http'
import bodyParser from 'body-parser';

var app = express()
var server = http.Server(app);

app.use(express.static(__dirname + '/../public'))

app.use(bodyParser.json())

app.get('/', function (req, res) {
  fs.readFile(__dirname + '/../public/index.html', function(err, data) {
    if (err) {
      res.writeHead(500)
      return res.end('Error loading index.html')
    }

    res.writeHead(200)
    res.end(data)
  })
})

// /data/user/login
// /data/user/create
// /data/user/logout
// /data/user/read
// /data/account/create
// /data/account/delete
// /data/query/create
// /data/query/update
// /data/query/delete
// /data/cron/update

console.log('aaaa')

app.post('/data/user/login', function (req, res) {
  res.json({
    cron: '5,10,30,55 7,8,9,11,12,13,16,17,18 * * *',
    accounts: [
      {
        username: 'charliejackson',
        queries: [
          '#iot',
          '#smarthome'
        ]
      }
    ],
    loggedIn: true
  })
})


server.listen(1337, function () {
  console.log('Example app listening on port 1337!')
})
