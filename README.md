# GMDprivateServer
## Geometry Dash Private Server
Basically a Geometry Dash Server Emulator

Supported version of Geometry Dash: 1.0 - 2.2

Song (custom content) downloading is supported only by Geometry Dash 2.2 and higher

(See [the backwards compatibility section of this article](https://github.com/Cvolton/GMDprivateServer/wiki/Deliberate-differences-from-real-GD) for more information)

Required version of PHP: 5.5+ (tested up to 8.1.2)

### Setup
1) Upload the files on a webserver
2) Import database.sql into a MySQL/MariaDB database
3) Edit the connection info at /config/connection.php (Set server to localhost if you're using localhost database)
4) Edit the public server name at /config/serverName.php (e.g., 192.168.0.xxx, example.com)
5) Optional: Change the server icon (icon.png) and description (/config/gdpsSwitcher.php)
6) Edit the links in GeometryDash.exe (note: since 2.1 some links are base64 encoded)

#### Updating the server
See [README.md in the `_updates`](_updates/README.md)

### Credits
Server implementation and original project by Cvolton - https://github.com/Cvolton/GMDprivateServer/

Base for account settings and the private messaging system by someguy28

Using this for XOR encryption - https://github.com/sathoro/php-xor-cipher - (incl/lib/XORCipher.php)

Using this for cloud save encryption - https://github.com/defuse/php-encryption - (incl/lib/defuse-crypto.phar)

Most of the stuff in generateHash.php has been figured out by pavlukivan and Italian APK Downloader, so credits to them
