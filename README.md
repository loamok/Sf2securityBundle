# Loamok Symfony 2 Security Bundle

A bundle for plug symfony to linux fail2ban security application

## First step rotate the logs

Start by configuring log rotate on your web server.

What you need :

1. Full path of your application logs
2. System webserver username
3. Root or sudo access
4. name of your application

Create an empty file in the logrotate config directory with a pattern like this :

```
$ sudo vim /etc/logrotate.d/sf2-appName
```

Write this in your new file (substitute with good values) :

```
/var/www/appName/app/logs/prod.log {
        su www-data www-data
        daily
        missingok
        rotate 14
        compress
}
```

Then (if your application has already started working and do logs) force first rotating :

```
$ sudo logrotate --force /etc/logrotate.d/sf2_appName
```

