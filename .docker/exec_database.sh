
echo "creating table structure ..."
#cat .docker/mysql/database.sql | docker exec -i pnc-mysql /usr/bin/mysql -uroot -proot penacova
echo "dumping data ..."
cat .docker/mysql/dump.sql | docker exec -i oceania-mysql /usr/bin/mysql -uroot -proot oceania

echo "\n you can access and test database with codes like: \n"
echo "docker exec -i oceania-mysql /usr/bin/mysql -uroot -proot oceania <<< 'SHOW TABLES;'"


# docker exec -i pnc-mysql /usr/bin/mysql -uroot -proot penacova <<< "SHOW TABLES;"

# docker exec -i oceania-mysql mysqldump -uroot -proot oceania > /application/mysqldump.sql