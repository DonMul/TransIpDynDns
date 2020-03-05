# TransIP Dynamic DNS updater
## What does it do?
When periodically running this codebase, you can update a specific DNS record for a specific domain registered at
TransIP in your account. This might come in handy if, for example, your ISP changes your IP address quite often and you
need a record always pointing to you.

## How to use
First of all, download this codebase and upload it to where ever you deem fit. After that go to that directory and run
the following command:
```
composer install
```

This will install all dependencies. Afterwards, copy the `settings.ini.example` to the same directory and name it 
`settings.ini`, then fill in the right settings:
* `login` = Username at TransIP
* `privateKey` = Private API key generated in the control panel of TransIP
* `domain` = The domain name you want to run the dyndns script for
* `record` = the name of the record you want to update (also known as Subdomain)
* `ttl` = Lifetime of your record (optional)

Then either run the `example.php` manually or add it to your crontab ( `* * * * * php /path/to/example.php` ) to 
automate this.