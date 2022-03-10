using System;
using System.Threading.Tasks;
using InfluxDB.Client;
using InfluxDB.Client.Api.Domain;
using InfluxDB.Client.Writes;

namespace Examples
{
    public class WriteExample
    {
        public static async Task Main(string[] args)
        {
            var url = "https://us-west-2-1.aws.cloud2.influxdata.com";
            var token = "my-token";
            var org = "my-org";

            using var client = InfluxDBClientFactory.Create(url, token);
            var writeApi = client.GetWriteApiAsync();

            var point = PointData.Measurement("weatherstation")
                .Tag("location", "San Francisco")
                .Field("temperature", 25.5)
                .Timestamp(DateTime.UtcNow, WritePrecision.Ns);

             await writeApi.WritePointAsync(point, "my-bucket", org);
        }
    }
}