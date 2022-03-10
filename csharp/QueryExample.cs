using System;
using System.Threading.Tasks;
using InfluxDB.Client;

namespace Examples
{
    public class QueryExample
    {
        public static async Task Main(string[] args)
        {
            var url = "https://us-west-2-1.aws.cloud2.influxdata.com";
            var token = "my-token";
            var org = "my-org";

            using var client = InfluxDBClientFactory.Create(url, token);

            var queryApi = client.GetQueryApi();
            var query = "from(bucket:\"my-bucket\") |> range(start: -1d)";
            var tables = await queryApi.QueryAsync(query, org);
            tables.ForEach(table =>
            {
                table.Records.ForEach(record =>
                {
                    Console.WriteLine(
                        $"{record.GetTime()} {record.GetMeasurement()}: {record.GetField()}={record.GetValue()}");
                });
            });
        }
    }
}