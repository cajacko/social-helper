import fs from 'fs'

export default function(req, res) {
  fs.readFile(__dirname + '/../server/index.html', function(err, data) {
    if (err) {
      res.writeHead(500)
      return res.end('Error loading index.html')
    }

    res.writeHead(200)
    res.end(data)
  })
}
