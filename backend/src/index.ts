import * as dotenv from 'dotenv'
import * as config from './config'
import * as server from './server'

// Load environment file
dotenv.config()

async function start() {
  try {
    console.log('Connected to database asyncly...')
  } catch(ex) {
    console.log(`Couldn't connect to a database: ${ex}`)
  }

  server.Instance.listen(config.port, () => {
    console.log(`Server listening on port ${config.port}...`)
  })
}

start()
