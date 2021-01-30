exports.url = process.env.MONGODB_URI || `mongodb://jr-db-service:27017`

exports.attr = {poolSize: 10, bufferMaxEntries: 0, useNewUrlParser: true, useUnifiedTopology: false, keepAlive: 300000, connectTimeoutMS : 30000 }