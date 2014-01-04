#Paste 2.0

##Demo
 http://phpaste.sourceforge.net/demo/


##Requirements: Apache + PHP + MySQL or PostgreSQL

##Installer
* Upload all files to a webfolder
* Point your browser to http://yoursite/<subdir?>/install
* Make sure config.php has write permissions (chmod 777)
* Input some settings, delete the install folder, revert config.php back to previous file permissions and you're ready to go.

##Manual Install
 * Create a database for PASTE.
 * Add the tables to the database (located in sql files, match the file to your DB software)
----------------------------------------------------------

The configuration file is pretty well documented (config.php)
so you shouldn't have any problems with it.
  
Any bugs can be reported at:
 https://sourceforge.net/tracker/?func=add&group_id=310876&atid=1308834
or 
 http://bitbucket.org/j-samuel/paste/issues/new/

##Changelog (2.0)
* Fully designed admin panel to delete pastes, manage users & site settings
* User dashboard to manage pastes & view insights
* Ability to comment on pastes
* Trends, archive, raw, stats & search pages
* Sign up with Facebook/Twitter
* Added some more themes, including Pastebinv2 (the current pastebin.com theme)
* Added an installer to create tables (only MySQL supported at the moment) and generate a config file
	
You can find support on IRC by connecting to irc.collectiveirc.net in channel #PASTE

##Credits
 * Paul Dixon (blog.dixo.net) for creating the original pastebin.com source.
 * Jorge Peña (http://www.blaenkdenum.com) for making numerous changes to the older source, 
 (archives which are now being reworked on and password protection)
 * Roberto Rodríguez (roberto.rodriguez.pino@gmail.com) for PostgreSQL support.

jQuery, Twitter Bootstrap and various jQuery addons for present and future features.
Icons are provided by fontawesome.