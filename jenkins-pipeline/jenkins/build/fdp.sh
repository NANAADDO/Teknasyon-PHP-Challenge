#!/bin/bash

echo "***************************"
echo "** Building New FDP IMAGE UPDATE ***********"
echo "***************************"


docker run --rm  -v  $PWD/java-app:/app -v /root/.m2/:/root/.m2/ -w /app maven:3-alpine "$@"

