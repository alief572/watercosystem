FROM mysql:5.7

# Copy custom MySQL configuration and ensure permissions are 644
# (MySQL ignores config files with world-writable 777 permissions on Windows mounts)
COPY my.cnf /etc/mysql/conf.d/custom.cnf
RUN chmod 644 /etc/mysql/conf.d/custom.cnf
