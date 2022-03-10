import java.time.Instant;

import com.influxdb.client.InfluxDBClient;
import com.influxdb.client.InfluxDBClientFactory;
import com.influxdb.client.WriteApi;
import com.influxdb.client.domain.WritePrecision;
import com.influxdb.client.write.Point;

public class WriteExample {
	public static void main(final String[] args) {
		String url = "https://us-west-2-1.aws.cloud2.influxdata.com";
		char[] token = "my-token".toCharArray();
		String org = "my-org";
		String bucket = "my-bucket";

		try (InfluxDBClient influxDBClient = InfluxDBClientFactory.create(url, token, org, bucket);
			WriteApiBlocking writeApi = influxDBClient.getWriteApiBlocking();
			Point point = Point.measurement("weatherstation")
					.addTag("location", "San Francisco")
					.addField("temperature", 25.5)
					.time(Instant.now(), WritePrecision.NS);

			writeApi.writePoint(point);
		}
	}
}
