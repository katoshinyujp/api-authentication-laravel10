FROM mysql:8
RUN echo "[client]" >> /etc/mysql/my.cnf
RUN echo "default-character-set=utf8" >> /etc/mysql/my.cnf
RUN echo "[mysql]" >> /etc/mysql/my.cnf
RUN echo "default-character-set=utf8" >> /etc/mysql/my.cnf
RUN echo "[mysqld]" >> /etc/mysql/my.cnf
RUN echo "default-authentication-plugin=mysql_native_password" >> /etc/mysql/my.cnf
RUN echo "innodb_log_file_size=256M" >> /etc/mysql/my.cnf
RUN echo "innodb_log_buffer_size=256M" >> /etc/mysql/my.cnf
RUN echo "innodb_strict_mode=0" >> /etc/mysql/my.cnf
RUN echo "collation-server=utf8_unicode_ci" >> /etc/mysql/my.cnf
RUN echo "character-set-server=utf8" >> /etc/mysql/my.cnf
