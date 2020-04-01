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
* `ttl` = Lifetime of your record (optional, default 300)
* `useIpv6` = Can be used to enable/disable ipv6 records to be created and updated (optional, default true)
* `records` = For each domain that you want to update records for, provide a list of the records you want to update, using the domain name as the key.

Make sure that the API key that you generate does not have IP whitelisting enabled! Otherwise it will be impossible to update the IP address of DNS records in case your IP changes.

Then either run the `run_once.php` manually or add it to your crontab ( `* * * * * php /path/to/run_once.php` ) to 
automate this.