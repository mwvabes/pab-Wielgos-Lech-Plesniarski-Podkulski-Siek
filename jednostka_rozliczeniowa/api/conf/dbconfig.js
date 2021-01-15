exports.url = PROCESS.ENV.MONGODB_URI || `mongodb://jr-db-service:27017`

exports.attr = {poolSize: 10, bufferMaxEntries: 0, useNewUrlParser: true, useUnifiedTopology: true}