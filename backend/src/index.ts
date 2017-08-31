import * as dotenv from 'dotenv'
import * as server from './server'

// Load environment file
dotenv.config();

async function start() {
  server.Instance.listen(process.env.PORT, () => {
    console.log(`Server listening on port ${process.env.PORT}...`)
  })
}

start()