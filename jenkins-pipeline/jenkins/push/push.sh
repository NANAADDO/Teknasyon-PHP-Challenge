#!/bin/bash

echo "********************"
echo "** Pushing image ***"
echo "********************"

IMAGE="farmgrow"

echo "** Logging in ***"
docker login -u farmgrow -p $PASS
echo "*** Tagging image ***"
docker tag farm-grow:$BUILD_TAG farmgrow/farmgrow-project:$BUILD_TAG
echo "*** Pushing image ***"
docker push farmgrow/farmgrow-project:$BUILD_TAG

