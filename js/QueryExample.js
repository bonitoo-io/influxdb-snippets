const {InfluxDB} = require('@influxdata/influxdb-client')

const url = 'https://us-west-2-1.aws.cloud2.influxdata.com'
const token = 'my-token'
const org = 'my-org'
const bucket = 'my-bucket'

const client = new InfluxDB({url: url, token: token})
const queryApi = client.getQueryApi(org)

const query = `from(bucket: "${bucket}") |> range(start: -1d)`

queryApi.queryRows(query, {
    next(row, tableMeta) {
        const o = tableMeta.toObject(row)
        console.log(`${o._time} ${o._measurement}: ${o._field}=${o._value}`)
    },
    error(error) {
        console.error(error)
        console.log('Finished ERROR')
    },
    complete() {
        console.log('Finished SUCCESS')
    },
})