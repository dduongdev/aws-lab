#!/bin/bash

dnf update -y

dnf install -y httpd mariadb105 php php-mysqli git

systemctl enable httpd
systemctl start httpd

cd /var/www/html

git clone https://github.com/dduongdev/aws-lab.git

cd aws-lab

mysql -h abc -P 3306 -u admin -padmin_pass --ssl < ./sql/schema.sql

cat << 'EOF' > .env
DB_HOST=abc
DB_PORT=3306
DB_NAME=user_auth
DB_USER=
DB_PASS=
EOF

systemctl restart httpd