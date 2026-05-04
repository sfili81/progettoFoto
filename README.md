

- Clone project from github `[git clone -address- folder-to-clone]`
- Launch `composer install` to create vendor directory
- Launch `npm install`
- Enter into [nome app] directory and launch 'php init'
- Into `.env.dist` you will find the accesses for the db under development
- Launch `cp .env.dist .env` and then modify the .env file
- Create a new database
- Open a console terminal, apply migrations with command `php yii migrate`
- If you use xamp read [host yii2 xampp](docs/XAMPP.md)
- Now you base Yii-Application must work</li>
- If you want to use Tailwind and Webpack you must first install node etc etc Follow Guide


### MAC OS

1. Dal terminale digitare:
   ``` 
   sudo nano /etc/hosts 
   ```

2. Si aprirà un file, aggiungere in fondo il nome del sito locale:
   ``` 127.0.0.1  yiicms.com ```

3. Salvare con `CTRL + X ` 

4. Aggiungere nel file `httpd-vhosts.conf` (Applicazioni/config/apache//extra/) le seguenti regole
    ```
    <VirtualHost *:80>
    DocumentRoot "/Applications/MAMP/htdocs/progettofoto"
    ServerName progettofoto.local
    ServerAlias progettofoto.local
    <Directory "/Applications/MAMP/htdocs/progettofoto"> 
                AllowOverride all
                Require all granted 
    </Directory> 
</VirtualHost>
    ``` 
5. Stoppare mampp e riavviarlo 
