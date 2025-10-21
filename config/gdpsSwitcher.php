<?php
require_once __DIR__ . "/servername.php";
# A message of the day for the server - Based off of Minecraft's system.
# Color tags are supported, although fade, delay, and shake tags are not.
# You can find all color tags at https://wyliemaster.github.io/gddocs/#/topics/tags?id=colour-tags
# Alternatively, you can use hex colors, for example <c-AEAEAE>Text</c> would be gray.
# Limited of 60 visible characters to prevent overflow.
$motd = "A Geometry Dash Private Server.";

# The link to the icon for the server.
# This should be a link to a png.
$protocol = (!empty($_SERVER['HTTPS']) && $_SERVER['HTTPS'] !== 'off') ? "https" : "http";
$icon = "$protocol://$publicservername/icon.png";
?>