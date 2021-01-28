#!/bin/bash

new_dir=temp-build-folder
workspace_dir=/var/jenkins_home/workspace
# Copy the new jar to the build location

echo "****************************"
echo "** CD Into Workspace and creating  Temp-folder ***"
echo "****************************"
cd $workspace_dir/  && rm -rf $new_dir &&  mkdir $new_dir

echo "****************************"
echo "** Copying New Update From Git to Temp folder ***"
echo "****************************"
cp -a complete-pipeline/.  $new_dir/

echo "****************************"
echo "** Deleting some files and folder to avoid conflict in temp folder ***"
echo "****************************"
cd $new_dir/ && rm  -f  Dockerfile docker-compose.yml Jenkinsfile
rm  -rf jenkins-pipeline .git

echo "****************************"
echo "** Copying Files to Build Image Folder in workspace ***"
echo "****************************"
cd .. && cp -a  $new_dir/.   complete-pipeline/jenkins-pipeline/jenkins/build/

echo "****************************"
echo "** Deleting Tempfolder After Copying to Build Folder ***"
echo "****************************"
rm -rf $new_dir/

#cp .env.example .env
echo "****************************"
echo "** Building Docker Image ***"
echo "****************************"
export BUILD_TAG=10
export Path=/Users/macbook/Desktop/fdp_kasapin/jenkins_home/workspace/complete-pipeline/jenkins-pipeline/jenkins/build
#export Path=/Users/macbook/Desktop/fdp_kasapin/test_volume
cd complete-pipeline/jenkins-pipeline/jenkins/build/ && docker-compose  build  && docker-compose up -d


docker exec -t farm-grow bash  -c  "composer install;php artisan config:cache;php artisan key:generate"
