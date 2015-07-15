<?php

//custom php header for MIME type. Required for serving Plist files.
header('Content-type: application/x-apple-aspen-config; chatset=utf-8');
header('Content-Disposition: attachment; filename="generated.mobileconfig"');
echo $mobileconfig;
?>
