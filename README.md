

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


Per far sì che il terminale usi il PHP di MAMP, aggiungi questa riga al tuo `~/.zshrc`:
`export PATH=/Applications/MAMP/bin/php/php8.3.x/bin:$PATH`
Sostituisci php8.3.x con il nome esatto della cartella. Prima verificalo con:
`ls /Applications/MAMP/bin/php/`
Ti elencherà le versioni installate, es. php8.3.4. Poi:
bash# Apri il file di configurazione
`nano ~/.zshrc`

 Aggiungi in fondo
`export PATH=/Applications/MAMP/bin/php/php8.3.4/bin:$PATH`
Salva con Ctrl+O → Invio → Ctrl+X, poi ricarica:
`source ~/.zshrc`
Ora php -v dovrebbe mostrarti la 8.3. Se usi bash invece di zsh, il file è `~/.bash_profile` anziché `~/.zshrc`.

a ME aveva dato buona questa `export PATH="/opt/homebrew/opt/php@8.3/bin:/opt/homebrew/opt/php@8.3/sbin:$PATH"`
