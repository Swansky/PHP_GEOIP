### migration csv to bdd script 


how to use:

```php
php migrate_geoip_csv.php -p data/geoip.csv
```

args available

``` php
php migrate_geoip_csv.php --help 
php migrate_geoip_csv.php --path <path>
php migrate_geoip_csv.php --separator <separator>
php migrate_geoip_csv.php --path <path> --end <char>
php migrate_geoip_csv.php --method <0:1> 
```

For more information please use help comand.

#Method

### Classic (0)
This method parse the csv file and insert each line in the database.
If the file is large it can take a long time. It can go up to several hours.

### Fast (1)
This method sends the csv file to the sql server. This method requires that the file transfer is enabled in the SQL server.
```sql
SET GLOBAL local_infile=1;
```
