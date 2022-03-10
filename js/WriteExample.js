const {InfluxDB} = require("@influxdata/influxdb-client");

const url = 'https://us-west-2-1.aws.cloud2.influxdata.com'
const token = "my-token";
const org = "my-org";
const bucket = "my-bucket"

const client = new InfluxDB({url: url, token: token});
const {Point} = require("@influxdata/influxdb-client");

const writeApi = client.getWriteApi(org, bucket);
const point = new Point("weatherstation")
    .tag("location", "San Francisco")
    .floatField("temperature", 23.4)
    .timestamp(new Date());

writeApi.writePoint(point);

writeApi
    .close()
    .then(() => {
        console.log("FINISHED");
    })
    .catch(e => {
        console.error(e);
        console.log("Finished ERROR");
    });