import java.util.List;

import com.influxdb.client.InfluxDBClient;
import com.influxdb.client.InfluxDBClientFactory;
import com.influxdb.query.FluxRecord;
import com.influxdb.query.FluxTable;

public class QueryExample {

	public static void main(final String[] args) {
		String url = "https://us-west-2-1.aws.cloud2.influxdata.com";
		char[] token = "my-token".toCharArray();
		String org = "my-org";
		String bucket = "my-bucket";

		try (InfluxDBClient client = InfluxDBClientFactory.create(url, token, org, bucket)) {
			String query = "from(bucket: \"my-bucket\") |> range(start: -1h)";
			List<FluxTable> tables = client.getQueryApi().query(query, org);

			for (FluxTable table : tables) {
				for (FluxRecord record : table.getRecords()) {
					System.out.printf("%s %s: %s=%s %n",
							record.getTime(),
							record.getMeasurement(),
							record.getField(),
							record.getValue());
				}
			}
		}
	}
}