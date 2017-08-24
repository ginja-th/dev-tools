import * as http from 'http'
import * as url from 'url'
import * as path from 'path'
import * as express from 'express'
import * as bodyParser from 'body-parser'
import * as logger from 'morgan'
import * as cors from 'cors'
import * as webhooksRouter from './routes/webhooks'
import * as api from './helpers/api'
import {Request, Response} from 'express'

var app = express()

/**
 * Middleware
 */
app.use(cors())
app.use(bodyParser.json())
app.use(bodyParser.urlencoded({ extended: false }))
app.use(logger('dev'))

/**
 * Routes
 */
app.use('/webhooks', webhooksRouter)

// 404 handler
app.get('*', (req: Request, res: Response) => {
  res.json(api.missing())
});

// Start the server...
export var Instance = http.createServer(app)
