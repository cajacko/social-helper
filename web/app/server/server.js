import environment from './environment'
import express from 'express'
import http from 'http'
import bodyParser from 'body-parser'
import session from 'express-session'
import {postFromFrontEnd} from './postToAPI'
import serveHTML from './serveHTML'
import twitterLogin from './twitterLogin'
import twitterCallback from './twitterCallback'

// Initialise
let app = express()
let server = http.Server(app);

// Middleware
app.use(express.static(__dirname + '/../public'))
app.use(session({secret: process.env.SESSION_SECRET}))
app.use(bodyParser.json())

// Routes
app.get('/', serveHTML)
app.get('/auth/twitter/login', twitterLogin)
app.get('/auth/twitter/callback', twitterCallback)
app.post('/data/:controller/:endpoint', postFromFrontEnd)

// Listen
server.listen(1337)
