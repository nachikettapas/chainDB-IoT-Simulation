package main

import (
	"encoding/base64"
	"fmt"
	"flag"

	b58 "github.com/jbenet/go-base58"
)

var b64Encoding = base64.NewEncoding("ABCDEFGHIJKLMNOPQRSTUVWXYZabcdefghijklmnopqrstuvwxyz0123456789~_").WithPadding(base64.NoPadding)

func main() {
	flag.Parse()

	fmt.Println(b64Encoding.EncodeToString(b58.Decode(flag.Arg(0))))
}

