<?php

//imports external libraries(deprecated)
require_once '_getVars.php';
require_once '_function.php';
require_once '_header.php';

/* functions
*/

//random string generator
//this function generates the random string needed for naming files
//for safety, you can improvise the entropy in $characters to make it more safe.
//for improvisation, simply use $examplevar = generateRandomString(); to get it.
function generateRandomString($length = 10) {
    $characters = '0123456789abcdefghijklmnopqrstuvwxyzABCDEFGHIJKLMNOPQRSTUVWXYZ';
    $charactersLength = strlen($characters);
    $randomString = '';
    for ($i = 0; $i < $length; $i++) {
        $randomString .= $characters[rand(0, $charactersLength - 1)];
    }
    return $randomString;
}

//iPhone response fetcher
//fetches iOS response to mobileconfig in DER encoding
function iPhoneResponseFetcher() {
$iPhoneSignedResponse = file_get_contents('php://input');
return $iPhoneSignedResponse;
}

//VPN Plist Generator
//this function writes to an .mobileconfig file to generate the VPN settings
//variables $server, $pass, $username $declaration $currentString needed
//C48E8706C2=currentString
function vpnPlistGenerator($server, $pass, $username, $declaration, $currentString) {
    $mobileconfig = fopen("mobileconfig/com.phpplistgenerator.vpn.".$currentString.".mobileconfig","w") or die("unable to generate mobileconfig file.");
    $mcdata = '
<?xml version="1.0" encoding="UTF-8"?>
<!DOCTYPE plist PUBLIC "-//Apple//DTD PLIST 1.0//EN" "http://www.apple.com/DTDs/PropertyList-1.0.dtd">
<plist version="1.0">
<dict>
	<key>ConsentText</key>
	<dict>
		<key>default</key>
		<string>'.$declaration.'</string>
	</dict>
	<key>DurationUntilRemoval</key>
	<integer>7776000</integer>
	<key>PayloadContent</key>
	<array>
		<dict>
			<key>IPv4</key>
			<dict>
				<key>OverridePrimary</key>
				<integer>1</integer>
			</dict>
			<key>PPP</key>
			<dict>
				<key>AuthName</key>
				<string>'.$username.'</string>
				<key>AuthPassword</key>
				<string>'.$pass.'</string>
				<key>CCPEnabled</key>
				<integer>1</integer>
				<key>CCPMPPE128Enabled</key>
				<integer>1</integer>
				<key>CCPMPPE40Enabled</key>
				<integer>1</integer>
				<key>CommRemoteAddress</key>
				<string>'.$server.'</string>
			</dict>
			<key>PayloadDescription</key>
			<string>Configures VPN settings</string>
			<key>PayloadDisplayName</key>
			<string>VPN</string>
			<key>PayloadIdentifier</key>
			<string>imac.ADC102F1-098C-4C3C-8134-88519C44ABDE.com.apple.vpn.managed.4DA3CB7A-4625-4072-B2E9-'.$currentString.'29</string>
			<key>PayloadType</key>
			<string>com.apple.vpn.managed</string>
			<key>PayloadUUID</key>
			<string>4DA3CB7A-4625-4072-B2E9-C48E8706C229</string>
			<key>PayloadVersion</key>
			<real>1</real>
			<key>Proxies</key>
			<dict/>
			<key>UserDefinedName</key>
			<string>phpPlistGenerator-'.$server.'-PPTP</string>
			<key>VPNType</key>
			<string>PPTP</string>
		</dict>
			</array>
	<key>PayloadDescription</key>
	<string>phpPlistGenerator VPN For user of port'.$username.' version '.$currentString.' usermode</string>
	<key>PayloadDisplayName</key>
	<string>phpPlistGenerator version '.$currentString.' usermode</string>
	<key>PayloadIdentifier</key>
	<string>imac.ADC102F1-098C-4C3C-8134-88'.$currentString.'</string>
	<key>PayloadOrganization</key>
	<string>com.phpplistgenerator.vpn.mobileconfig</string>
	<key>PayloadRemovalDisallowed</key>
	<false/>
	<key>PayloadType</key>
	<string>Configuration</string>
	<key>PayloadUUID</key>
	<string>6426CF89-5EF4-4064-B0B7-E9'.$currentString.'</string>
	<key>PayloadVersion</key>
	<integer>1</integer>
</dict>
</plist>
            ';//<-end of $mcdata, no touch!
    
fwrite($mobileconfig, $mcdata);
fclose($myfile);
$filename = 'mobileconfig/com.phpplistgenerator.vpn.'.$currentString.'.mobileconfig';
return $filename or die("unable to fetch the mobileconfig file\n");
}
//end of VPN Plist Generator


//LDAP Directory Settings Generator
//Inserts the LDAP directory server in to iOS device and sets up a mail address automatically
//requires vars $declaration $currentString $ldapserver $imapserver $smtpserver $mailusername $mailpassword $ldapserverpreffix $ldapserversuffix $mailuseraddress
function ldapPlistGenerator ($declaration, $currentString, $ldapserver, $ldapserverprefix,$ldapserversuffix,$mailserver, $mailusername, $mailuseraddress, $mailpassword){
 $mobileconfig = fopen("mobileconfig/com.phpplistgenerator.ldap.".$currentString.".mobileconfig","w") or die("unable to generate mobileconfig file.");
    $mcdata = '
    <?xml version="1.0" encoding="UTF-8"?>
    <!DOCTYPE plist PUBLIC "-//Apple/DTD PLIST 1.0//EN" "http://www.apple.com/DTDs/PropertyList-1.0.dtd">
    <plist version="1.0">
    <dict>
	<key>PayloadContent</key>
	<array>
		<dict>
			<key>PayloadDisplayName</key>
			<string>LDAP Settings</string>
			<key>PayloadType</key>
			<string>com.apple.ldap.account</string>
			<key>PayloadVersion</key>
			<integer>1</integer>
			<key>PayloadUUID</key>
			<string>6df7a612-ce0a-4b4b-bce2-7b'.$currentString.'</string>
			<key>PayloadIdentifier</key>
			<string>com.example.iPhone.settings.ldap</string>
			<key>LDAPAccountDescription</key>
			<string>Company Contacts</string>
			<key>LDAPAccountHostName</key>
			<string>'.$ldapserver.'</string>
			<key>LDAPAccountUseSSL</key>
			<false />
			<key>LDAPAccountUserName</key>
			<string>uid=username,dc='.$ldapserverprefix.',dc='.$ldapserversuffix.'</string>
			<key>LDAPSearchSettings</key>
			<array>
				<dict>
					<key>LDAPSearchSettingDescription</key>
					<string>Company Contacts</string>
					<key>LDAPSearchSettingSearchBase</key>
					<string></string>
					<key>LDAPSearchSettingScope</key>
					<string>LDAPSearchSettingScopeSubtree</string>
				</dict>
			</array>
		</dict>
		<dict>
			<key>PayloadDisplayName</key>
			<string>Email Settings</string>
			<key>PayloadType</key>
			<string>com.apple.mail.managed</string>
			<key>PayloadVersion</key>
			<integer>1</integer>
			<key>PayloadUUID</key>
			<string>362e5c11-a332-4dfb-b18b-f6f0aac032fd</string>
			<key>PayloadIdentifier</key>
			<string>com.example.iPhone.settings.email</string>
			<key>EmailAccountDescription</key>
			<string>Company E-mail</string>
			<key>EmailAccountName</key>
			<string>'.$mailusername.'</string>
			<key>EmailAccountType</key>
			<string>EmailTypeIMAP</string>
			<key>EmailAddress</key>
			<string>'.$mailuseraddress.'</string>
			<key>IncomingMailServerAuthentication</key>
			<string>EmailAuthPassword</string>
			<key>IncomingMailServerHostName</key>
			<string>'.$mailserver.'</string>
			<key>IncomingMailServerUseSSL</key>
			<true />
			<key>IncomingMailServerUsername</key>
			<string>'.$mailuseraddress.'</string>
			<key>OutgoingPasswordSameAsIncomingPassword</key>
			<true />
			<key>OutgoingMailServerAuthentication</key>
			<string>EmailAuthPassword</string>
			<key>OutgoingMailServerHostName</key>
			<string>'.$mailserver.'</string>
			<key>OutgoingMailServerUseSSL</key>
			<true />
			<key>OutgoingMailServerUsername</key>
			<string>'.$mailuseraddress.'</string>
		</dict>
	</array>
	<key>PayloadOrganization</key>
	<string>Alex Fangs Plist Generator</string>
	<key>PayloadDisplayName</key>
	<string>Alex Fangs Plist Generator</string>
	<key>PayloadVersion</key>
	<integer>1</integer>
	<key>PayloadUUID</key>
	<string>954e6e8b-5489-484c-9b1d-0c9b7bf18e32</string>
	<key>PayloadIdentifier</key>
	<string>com.example.iPhone.settings</string>
	<key>PayloadDescription</key>
	<string>'.$declaration.'</string>
	<key>PayloadType</key>
	<string>Configuration</string>
</dict>
</plist>
            ';//<-end of $mcdata, no touch!
    
fwrite($mobileconfig, $mcdata);
fclose($myfile);
$filename = 'mobileconfig/com.phpplistgenerator.ldap.'.$currentString.'.mobileconfig';
return $filename or die("unable to fetch the mobileconfig file\n");
}
//end of LDAP Plist Generator


?>