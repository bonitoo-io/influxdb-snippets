package main

import (
	"context"
	"github.com/influxdata/influxdb-client-go/v2"
	"time"
)

func main() {
	url := "https://us-west-2-1.aws.cloud2.influxdata.com"
	token := "my-token"
	org := "my-org"
	bucket := "my-bucket"

	client := influxdb2.NewClient(url, token)
	writeAPI := client.WriteAPIBlocking(org, bucket)
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
