#!/bin/bash
 keypath=/var/jenkins_home/.ssh/$public_key
 server_ip=$SERVER_IP
 pubpath=/opt/.backup
remotepath=/home/ubuntu/

echo $BUCKET_URL > $pubpath/data
echo $SAS_KEY >> $pubpath/data

echo "****************************"
echo "** copying backup data files to production/dev server"
echo "****************************"
scp -i $keypath  $pubpath/data ubuntu@$server_ip:$remotepath/.backup

echo "****************************"
echo "** copying backup data files to production/dev server"
echo "****************************"
scp -i $keypath  $pubpath/data ubuntu@$server_ip:$remotepath/.backup


echo "****************************"
echo "** copying publish files to production/dev server ***"
echo "****************************"
scp -i $keypath /opt/publishblob ubuntu@$server_ip:$remotepath/publishblob

echo "****************************"
echo "** Executing publish script in production ***"
echo "****************************"
#ssh -i $keypath ubuntu@$server_ip "$remotepath/publishblob"

