==============================
This is Paste (In Development)
==============================
Paste is forked from the original source pastebin.com used before it was bought.
The original source is available from the previous owner's `GitHub repository <https://github.com/lordelph/pastebin>`_
If you would like to contribute to developing Paste please feel free to find me on IRC. 

A demo of Paste is available on our homepage at `SourceForge <http://phpaste.sourceforge.net/demo>`_
======================================================================


.. image:: http://i.imgur.com/8fqrIan.png

Requirements: Apache + PHP + MySQL or PostgreSQL
================================================

Installer (In Development)
=========
* Create a database for PASTE.
* Upload all files to a webfolder
* Point your browser to http://yourpas.te/installation/install
* Input some settings, copy & paste the generated config into config.php, DELETE the install folder and you're ready to go.

Manual Install
==============
* Create a database for PASTE.
* Add the tables to the database (located in sql files, match the file to your DB software)
* Edit config.edit.php and rename to config.php

The configuration file is pretty well documented (config.php)
so you shouldn't have any problems with it.
  
Any bugs can be reported at:
http://bitbucket.org/j-samuel/paste/issues/new/

You can find support on IRC by connecting to irc.collectiveirc.net in channel #PASTE

-----------------------------------------------------------------------------------------------------

====================
TODO (for version 2)
====================
* Integrate an admin panel (delete user pastes, manage site configuration) and a user dashboard
  (user registration, insights, modify/delete pastes [...] 
* Add ability to comment on pastes
* Trends, archive, raw, stats & search pages
* Social integration (create accounts with Facebook, Twitter etc)
* Create an installer
	
-----------------------------------------------------------------------------------------------------

Credits
=======
Paul Dixon (`blog.dixo.net <http://blox.dixo.net>`_) for developing `the original pastebin.com <https://github.com/lordelph/pastebin>`_

Roberto Rodríguez (roberto.rodriguez.pino[AT]gmail.com) for PostgreSQL support.

Themes were built using jQuery &  Twitter Bootstrap and various jQuery plugins for
present and future features, but we do try to keep it bloat free.
Icons are provided by FontAwesome.