General Information on the FPA Script:

The Forum Post Assistant has been designed to assist newcomers to the forum to be able to post relevant system, instance, php and troubleshooting information directly in to a pre-formatted forum post. This should save a few hours of posting back and forth, asking for, and explaining how to acquire useful information in order for other forum users to help troubleshoot a problem.
This process also means that consistent information is gathered and presented in every case, enabling helpers to quickly target information relevant to the specific problem observed by the user.
The idea is to make the information collection, and subsequent posting, as simple as possible for the end user, a simple script, automatically collects the information when run in a web-browser and presents the user with the option to include or exclude any site sensitive information before "generating" the post [BB]code that can then be copied and simply pasted in to a new or existing forum post with no other interaction by the user required after posting.
USE AT YOUR OWN RISK Accuracy and completeness of this script and documentation is not assured and no responsibility will be accepted for any damage, issues or confusion caused by using versions contained within these branches. 

Compatibility:
	PHP 4.1,PHP4, 5, 6DEV	  MySQL 3.2 - 5.5 	MySQLi from 4.1 ( @ >=PHP 4.4.9)
 	
Joomla! Version Support:
	  | J!3.0 | J!2.5.xx | J!1.7.xx | J!1.6.xx | J1.5.xx |  J!1.0.xx  | 
	
Language Support:
English (USA/UK/AU)
Community language translations may be available.  As translations become available, each localized version will be released into it's own "branch" (EG: fr_FR, de_DE) and will be available for download from the "Download" button (in .tar.gz or .zip format) within the localized branch.  All files that are needed have been automatically added to the download package.

Known Issues:
FPA is not currently compatible with Joomla websites that have had their configuration.php file moved outside of the public_html directory.

Installation:
1. Download the desired archive 
2. Uncompress the downloaded package file on your own computer (using WinZip or a native decompression tool).
3. READ the included README file for any special Release notes.
4. READ the included Documentation file for detailed usage instructions.
5. Upload the fpa-xx.php script (replace xx with the language version you downloaded) to your Joomla! Site Root "/" directory. This is the place you installed Joomla and may not be the main root for your server. See examples below.
6. Run the script through your browser by entering: http://www.mysite.com/fpa-xx.php substitute your domain for www.mysite.com and substitute the language version you downloaded for the xx. See examples below.

Examples:
Joomla! is installed in your web-root folder and you installed the English version of the FPA script: 
Upload the fpa-en.php script to: <your-domain-name.com>/public_html/
To run the script:  http://www.<your-domain-name>.com/fpa-en.php 

Joomla! is installed in a sub-directory named "cms" and you installed the English version of the FPA script:
Upload the fpa-en.php script to:  <your-domain-name.com>/public_html/cms/ 
To run the script:  http://www.<your-domain-name>.com/cms/fpa-en.php


Due to the highly sensitive nature of the information displayed by the FPA script, it should be removed from the server immediately after use.
To remove the script from your website use the delete script link provided at the top of the scripts page. If using the removal link fails to remove the script, then use your ftp program to manually remove the script or otherwise change the name once the script has generated 
the Site Data and the message has been prepared and posted to the forum. If the script is left on the site, it can be used to gather enough information to hack your site.
Removing the script will prevent outsiders from using it to take a look at how your site is structured and possibly utilize any flaws that may be present.
