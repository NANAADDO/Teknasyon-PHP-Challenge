#!/bin/bash
keypath=/var/jenkins_home/.ssh/$public_key
toutonip=$SERVER_IP
pubpath=/opt/.backup
remotepath=/home/ubuntu/

echo $DB_HOST > $pubpath/data
echo $DB_PASSWORD >> $pubpath/data
echo $DB_NAME >> $pubpath/data
echo $AWS_SECRET >> $pubpath/data
echo $BUCKET_NAME >> $pubpath/data
echo $AWS_ACCESS >> $pubpath/data

echo "****************************"
echo "** copying backup data files to production/dev server"
echo "****************************"
scp -i $keypath  $pubpath/data ubuntu@$toutonip:$remotepath/.backup


echo "****************************"
echo "** copying publish files to production/dev server ***"
echo "****************************"
scp -i $keypath /opt/publishs3 ubuntu@$toutonip:$remotepath/publishs3

echo "****************************"
echo "** Executing publish script in production ***"
echo "****************************"
ssh -i $keypath ubuntu@$toutonip "$remotepath/publishs3"


