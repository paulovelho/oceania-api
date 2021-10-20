#!/bin/bash
echo "----------------------------------------------------------------"
echo "-------------magrathea docker config----------------------------"
echo "----------------------------------------------------------------"

phpUser="www-data"

# mkdir -p app/database
# chown $phpUser:$phpUser app/database

mkdir -p app/plugins
chown $phpUser:$phpUser app/plugins
echo -e "\tplugins = ok\n"

if [ -d app/css/_compressed ]; then rm -Rf app/css/_compressed; fi
mkdir app/css/_compressed
touch app/css/_compressed/index.html
chown $phpUser:$phpUser app/css/_compressed
echo -e "\tcss-compression folder = ok\n"

if [ -d app/javascript/_compressed ]; then rm -Rf app/javascript/_compressed; fi
mkdir app/javascript/_compressed
touch app/javascript/_compressed/index.html
chown $phpUser:$phpUser app/javascript/_compressed
echo -e "\tjavascript-compression folder = ok\n"

# views
touch app/Views/index.html

if [ -d app/Views/_cache ]; then rm -Rf app/Views/_cache; fi
mkdir app/Views/_cache
touch app/Views/_cache/index.html
chown $phpUser:$phpUser app/Views/_cache

if [ -d app/Views/_compiled ]; then rm -Rf app/Views/_compiled; fi
mkdir app/Views/_compiled
touch app/Views/_compiled/index.html
chown $phpUser:$phpUser app/Views/_compiled

if [ -d app/Views/_configs ]; then rm -Rf app/Views/_configs; fi
mkdir app/Views/_configs
touch app/Views/_configs/site.conf
touch app/Views/_configs/index.html
echo -e "\tViews = ok\n"

if [ -d logs ]; then rm -Rf logs; fi
mkdir logs
chown $phpUser:$phpUser logs
echo -e "\tlogs = ok\n"

if [ -d app/Static ]; then rm -Rf app/Static; fi
mkdir app/Static
chown $phpUser:$phpUser app/Static
echo -e "\tStatic folder = ok\n"

mkdir -p app/images/medias
chown $phpUser:$phpUser app/images/medias
if [ -d app/images/medias/_generated ]; then rm -Rf app/images/medias/_generated; fi
mkdir -p app/images/medias/_generated
chown $phpUser:$phpUser app/images/medias/_generated
echo -e "\tImages folder = ok\n"


# ===> run with:
# ./.docker/exec_magrathea.sh

