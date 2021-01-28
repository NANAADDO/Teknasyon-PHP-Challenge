#/bin/bash

#./azcopy copy "/Users/macbook/Desktop/fdp-country.sql" "https://#farmgrowdiag.blob.core.windows.net/fdp-db-backups/fdp.sql?#sv=2019-12-12&ss=bfqt&srt=sco&sp=rwdlacupx&se=2022-04-01T01:37:40Z&st=2020-11-22T17:37:40#Z&spr=https,http&sig=XrGY06qZ7IdJc%2Bs2ggwvod2TbimVI%2FX%2Bzju2ONTwIlA%3D"

DATE=$(date +%H-%M-%S)
BACKUP=db-$DATE.sql

remote_file=/tmp/.backup
BUCKET_URL=$(sed -n '1p' $remote_file)
SAS_KEY=$(sed -n '2p' $remote_file)

./azcopy copy "$BACKUP" "$BUCKET_URL/${BACKUP}${SAS_KEY}"
