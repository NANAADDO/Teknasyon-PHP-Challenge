#!/bin/bash
 keypath=/var/jenkins_home/.ssh/touton.pem
 toutonip=3.20.169.215
 pubpath=/opt/auth
remotepath=/home/ubuntu/.auth
echo farmgrow > $pubpath/.auth
echo $BUILD_TAG >> $pubpath/.auth
echo $PASS >> $pubpath/.auth

echo "****************************"
echo "** copying auth files to production/dev server"
echo "****************************"
scp -i $keypath  $pubpath/.auth ubuntu@$toutonip:$remotepath/.auth

echo "****************************"
echo "** copying publish files to production/dev server ***"
echo "****************************"
scp -i $keypath ./jenkins-pipeline/jenkins/deploy/publish ubuntu@$toutonip:$remotepath/publish

echo "****************************"
echo "** Executing publish script in production ***"
echo "****************************"
ssh -i $keypath ubuntu@$toutonip "$remotepath/publish"

