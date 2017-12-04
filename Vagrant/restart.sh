systemctl daemon-reload

service nginx restart
service php7.0-fpm restart
service cachefilesd restart

service elasticsearch restart
