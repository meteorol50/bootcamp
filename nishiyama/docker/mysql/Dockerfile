FROM mysql/mysql-server:8.0

# timezone (Asia/Tokyo)
ENV TZ Asia/Tokyo

# my.conf
COPY mysql.cnf /etc/mysql/conf.d/custom.cnf
RUN chmod 644 /etc/mysql/conf.d/custom.cnf
