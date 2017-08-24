// are we running in production?
export var isProd = process.env.NODE_ENV === 'production'

// the port the API should bind to
export var port = process.env.PORT || 3000

// of the format "postgres://someuser:somepassword@somehost:381/sometable"
export var postgresUri = process.env.POSTGRES_URI || 'postgres://localhost:27017/devtools'
