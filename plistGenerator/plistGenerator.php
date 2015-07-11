<?php

/**************
    phpPlistGenerator version 0.1 by Alex Fang.
    unless where lines of codes are noted, all rights reserved.
    licensed under Mr. Fang's favorite GNU General Public License Version 2.
    deBUG: frjalex@gmail.com & github.com/frjalex/phpPlistGenerator
***************/

//important NOTICE:document root must be set to owner www-data & permissions chmod 711!(globally writable)

//imports external libraries(deprecated)
require_once '_getVars.php';
require_once '_function.php';
require_once '_header.php';

//switch, case 1 is vpn
//case 2 is ldap
switch ($mode) {
case 1:
  $vpnfilepath = vpnPlistGenerator();
  echo "<h3>VPN plist Generator by Alex Fang</h3>\n";
  echo '<a href="'.$vpnfilepath.'">click here to download your plist file</a>';
  echo '<a href="//plistgenerator.derros.in/">Go Back</a>';
  echo "made with love by Alex Fang\n";
  echo "Reponse sent from your iOS device:\n";
  echo $iosReponseContent;
  break;
case 2:
  $ldapfilepath = ldapPlistGenerator();
  echo "<h3>LDAP plist Generator by Alex Fang</h3>\n";
  echo '<a href="'.$ldapfilepath.'">click here to download your plist file</a>';
  echo '<a href="//plistgenerator.derros.in/">Go Back</a>';
  echo "Reponse sent from your iOS device:\n";
  echo $iosReponseContent;
  break;
default:
  echo 'You are unlucky. <a href="//plistgenerator.derros.in">Go Back</a> and try again!';
}

?>



