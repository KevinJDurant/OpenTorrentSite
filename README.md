# OpenTorrentSite 

_**Current version "0.1.2"**_ 

A modern torrent search engine/website template that is easy to setup with an intuitive GUI. Engineered to be one of the easiest to use torrent websites out there. 

## Design
![Index](http://i.imgur.com/ovyRdj2.png)
![Detail](http://i.imgur.com/jly4Mch.png)
![Upload](http://i.imgur.com/YDtYYTt.png)

## Setup:
1. Copy & Paste all files to your webspace.
2. Setup a new MySQL database. For security purposes you should create a user with appropriate permissions.
3. Change the database credentials inside 'config/config.ini.php'.
4. Import all .sql files from the 'sql' folder.

## Current features:
- [x] User Register and Login.
- [x] Torrent Uploading.
- [x] Torrent Seed & Peer data.
- [x] Crossbrowser compatibility.
- [x] Mobile support.
- [x] Torrent Search.

For a full overview of available features and what's to come see [this gist](https://gist.github.com/KevinJDurant/690ff206779582a404d481ab0a165519). Note: a lot of parts will probably be insecure during the early stages of development.

## Open Source Credits for OpenTorrentSite:
* BCrypt compatibility library:
  -  [Project: password_compat v2.1.0](https://github.com/ircmaxell/password_compat)
  -  Copyright ©, Anthony Ferrara
  -  [License (MIT)](http://www.opensource.org/licenses/mit-license.html)
* Torrent RW:
  -  [Project: Torrent-rw v0.0.3](https://github.com/adriengibrat/torrent-rw)
  -  Copyright ©, Adrien Gibrat
  -  [License (GPLv3)](http://www.gnu.org/licenses/gpl.html)
* Normalize.css:
  -  [Project: normalize.css v5.0.0](https://github.com/necolas/normalize.css)
  -  Normalize.css is a project by Nicolas Gallagher, co-created with Jonathan Neal.
  -  [License (MIT)](https://github.com/necolas/normalize.css/blob/master/LICENSE.md)
* Scrapeer:
  -  [Project: Scrapeer v0.4.8](https://github.com/medariox/Scrapeer)
  -  Copyright ©, medariox
  -  [License (MIT)](http://www.opensource.org/licenses/MIT)
* Bootstrap:
  -  [Project: Bootstrap v3.3.7](http://getbootstrap.com)
  -  Code and documentation copyright 2011-2017 the Bootstrap Authors and Twitter, Inc.
  -  [License (MIT)](https://github.com/twbs/bootstrap/blob/master/LICENSE)
* Alertify.js:
  -  [Project: Validator, for Bootstrap 3 v0.11.9](https://github.com/1000hz/bootstrap-validator)
  -  Copyright ©, Cina Saffary
  -  [License (MIT)](https://github.com/1000hz/bootstrap-validator/blob/master/LICENSE)
* TinyMCE:
  -  [Project: TinyMCE v4.5.3](https://github.com/tinymce/tinymce)
  -  [License (LGPLv2.1)](https://github.com/tinymce/tinymce/blob/master/LICENSE.TXT)

## License
MIT © [Kevin Durant](https://github.com/KevinJDurant)
