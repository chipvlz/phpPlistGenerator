<?php

//get the imported variables using $_GET from html input

//global vars
$mode = $_GET['mode'];
$declaration = $_GET['declaration'];
$currentString = generateRandomString();//random string
$iosResponseContent = iPhoneResponseFetcher(); //retrieves the iOS response in DER encoding

//vars for vpnPlistGenerator
$server =  $_GET['server'];     //$node->Server();
$pass = $_GET['pass'];          //$oo->get_pass();
$username = $_GET['username'];  //$oo->get_port();

//vars for ldapPlistGenerator
$ldapserverprefix = $_GET['ldapserverprefix'];
$ldapserversuffix = $_GET['ldapserversuffix'];//apple has merely strange requirements on these, seperating root domain and 2nd level domains. I do not have very much documentations on this, but if anyone had a more artistic 
//solution, I would be very happy to fix.
$ldapserver = $ldapserverprefix.'.'.$ldapserversuffix; //use this merely strange way to get fqdn of ldap server. Documentation on this strongly needed.
$smtpserver = $_GET['mailserver']; //assuming SMTP IMAP and POP3 servers are on the same address 
$mailusername = $_GET['mailusername'];
$mailpassword = $_GET['mailpassword'];
$mailuseraddress = $mailusername.'@'.$mailserver;

?>