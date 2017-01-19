import environment from './environment'
import express from 'express'
import http from 'http'
import bodyParser from 'body-parser'
import session from 'express-session'
import {postFromFrontEnd} from './postToAPI'
import serveHTML from './serveHTML'
import twitterLogin from './twitterLogin'
import twitterCallback from './twitterCallback'
import sessionFileStore from 'session-file-store'

// Initialise
let app = express()
let server = http.Server(app)
let FileStore = sessionFileStore(session)

// Middleware
app.use(express.static(__dirname + '/../public'))

app.use(session({
  secret: process.env.SESSION_SECRET,
  store: new FileStore()
}))

app.use(bodyParser.json())

// Routes
app.get('/', serveHTML)
app.get('/auth/twitter/login', twitterLogin)
app.get('/auth/twitter/callback', twitterCallback)
app.post('/data/:controller/:endpoint', postFromFrontEnd)

// Listen
server.listen(1337)
