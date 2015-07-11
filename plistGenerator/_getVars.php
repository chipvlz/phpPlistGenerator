<?php
//imports external libraries(deprecated)
require_once '_getVars.php';
require_once '_function.php';
require_once '_header.php';
//get the imported variables using $_GET from html input

//global vars
$mode = $_POST['mode'];
$declaration = $_POST['declaration'];
$currentString = generateRandomString();//random string
$iosResponseContent = iPhoneResponseFetcher(); //retrieves the iOS response in DER encoding

//vars for vpnPlistGenerator
$server =  $_POST['server'];     //$node->Server();
$pass = $_POST['pass'];          //$oo->get_pass();
$username = $_POST['username'];  //$oo->get_port();

//vars for ldapPlistGenerator
$ldapserverprefix = $_POST['ldapserverprefix'];
$ldapserversuffix = $_POST['ldapserversuffix'];//apple has merely strange requirements on these, seperating root domain and 2nd level domains. I do not have very much documentations on this, but if anyone had a more artistic 
//solution, I would be very happy to fix.
$ldapserver = $ldapserverprefix.'.'.$ldapserversuffix; //use this merely strange way to get fqdn of ldap server. Documentation on this strongly needed.
$smtpserver = $_POST['mailserver']; //assuming SMTP IMAP and POP3 servers are on the same address 
$mailusername = $_POST['mailusername'];
$mailpassword = $_POST['mailpassword'];
$mailuseraddress = $mailusername.'@'.$mailserver;

?>