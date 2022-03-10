package main

import (
	"context"
	"fmt"
	"github.com/influxdata/influxdb-client-go/v2"
)

func main() {
	client := influxdb2.NewClient("https://us-west-2-1.aws.cloud2.influxdata.com", "my-token")
	queryAPI := client.QueryAPI("my-org")
	result, err := queryAPI.Query(context.Background(), `from(bucket:"my-bucket") |> range(start: -1d)`)
	if err != nil {
		panic(err)
	}
	for result.Next() {
		record := result.Record()
		fmt.Printf("%v %v: %v=%v\n", record.Time(), record.Measurement(), record.Field(), record.Value())
	}
	client.Close()
}
