package main

import (
	"context"
	"github.com/influxdata/influxdb-client-go/v2"
	"time"
)

func main() {
	client := influxdb2.NewClient("https://us-west-2-1.aws.cloud2.influxdata.com", "my-token")
	writeAPI := client.WriteAPIBlocking("my-org", "my-bucket")
	p := influxdb2.NewPointWithMeasurement("weatherstation").
		AddTag("location", "San Francisco").
		AddField("temperature", 25.7).
		SetTime(time.Now())

	err := writeAPI.WritePoint(context.Background(), p)
	if err != nil {
		panic(err)
	}
	client.Close()
}
