#Paste 2.0

Demo: http://phpaste.sourceforge.net/demo/
-----------------------------------------

Requirements: Apache + PHP + MySQL or PostgreSQL
------------------------------------------------

Manual Install
 1.1> Create a database for PASTE.
 1.2> Add the tables to the database
(located in sql files, match the file to your DB software)
----------------------------------------------------------

The configuration file is pretty well documented (config.php)
so you shouldn't have any problems with it.
  
Any bugs can be reported at:
https://sourceforge.net/tracker/?func=add&group_id=310876&atid=1308834
or http://bitbucket.org/j-samuel/paste/issues/new/

Changelog
---------
* Sleek new theme built using jQuery & Bootstrap
* Passwords are no longer stored as plain text (in the future pastes won't be either)
* Links are no longer broken if htaccess/mod_rewrite isn't available (see config)
	
Over the coming months we should see the placeholder
folders & files filled with new features.

You can find support on IRC by connecting to irc.collectiveirc.net in channel #PASTE

Credits
-------
 Paul Dixon (blog.dixo.net) for creating the original pastebin.com source.
 Jorge Peña (http://www.blaenkdenum.com) for making numerous changes to the older source, 
 (archives which are now being reworked on and password protection)
 Roberto Rodríguez (roberto.rodriguez.pino@gmail.com) for PostgreSQL support.

jQuery, Twitter Bootstrap and various jQuery addons for present and future features.
Icons are provided by fontawesome.