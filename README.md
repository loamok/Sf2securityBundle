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

## Install this bundle in your application

Composer.json :

```
    "require": {
        [...],
        "Loamok/Sf2securityBundle": "dev-master"
```

And run composer update.

Add it to your kernel AppKernel.php :

```
        $bundles = array(
            [...],
            \Loamok\Sf2securityBundle\Sf2securityBundle(),

```

Mod your security config file 

```
# app/config/security.yml
    firewalls:
        main:
            pattern: ^/
            form_login:
                provider: fos_userbundle
                csrf_provider: form.csrf_provider
                failure_handler: sf2security.authenticationfailurehandler
            logout:       true
            anonymous:    true
```

## plug-in to fail2 ban : 

Create a symbolic link from filter conf file to /etc/fail2ban/filter :

```
$ sudo ln -s /var/www/appName/vendor/Loamok/Sf2securityBundle/Loamok/Sf2securityBundle/Resources/filter/sf2security.conf /etc/fail2ban/filter/sf2security.conf
```

Add the jail definition for fail2ban (/etc/fail2ban/jail.conf) (sample is in the filter file) :

```
[sf2security]
enabled   = true
filter    = sf2security
logpath   = /var/www/appName/app/logs/prod.log
port      = http,https
bantime   = 600
banaction = iptables-multiport
maxretry  = 3
```

Restart fail2 ban service and that's it you just secure your symfony2 application against brutforce.

```
$ sudo service fail2ban restart
```
