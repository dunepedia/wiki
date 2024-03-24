<?php
# See includes/MainConfigSchema.php for all configurable settings
# and their default values.
#
# Further documentation for configuration settings may be found at:
# https://www.mediawiki.org/wiki/Manual:Configuration_settings

# Protect against web entry
if (!defined('MEDIAWIKI')) {
	exit;
}


$wgSitename = "Dunepedia";

$wgScriptPath = "";

$wgServer = "http://localhost:8080";

$wgResourceBasePath = $wgScriptPath;

$wgLogos = [
	'1x' => "$wgResourceBasePath/resources/assets/change-your-logo.svg",
	'icon' => "$wgResourceBasePath/resources/assets/change-your-logo.svg",
];

$wgEnableEmail = false;

$wgEmergencyContact = "caleb@dunepedia.net";
$wgPasswordSender = "caleb@dunepedia.net";

## Database settings
$wgDBtype = "sqlite";
$wgDBserver = "";
$wgDBname = "dunepedia";
$wgDBuser = "";
$wgDBpassword = "";

# SQLite-specific settings
$wgSQLiteDataDir = "/var/www/data";
$wgObjectCaches[CACHE_DB] = [
	'class' => SqlBagOStuff::class,
	'loggroup' => 'SQLBagOStuff',
	'server' => [
		'type' => 'sqlite',
		'dbname' => 'wikicache',
		'tablePrefix' => '',
		'variables' => ['synchronous' => 'NORMAL'],
		'dbDirectory' => $wgSQLiteDataDir,
		'trxMode' => 'IMMEDIATE',
		'flags' => 0
	]
];
$wgObjectCaches['db-replicated'] = [
	'factory' => 'Wikimedia\ObjectFactory\ObjectFactory::getObjectFromSpec',
	'args' => [['factory' => 'ObjectCache::getInstance', 'args' => [CACHE_DB]]]
];
$wgLocalisationCacheConf['storeServer'] = [
	'type' => 'sqlite',
	'dbname' => "{$wgDBname}_l10n_cache",
	'tablePrefix' => '',
	'variables' => ['synchronous' => 'NORMAL'],
	'dbDirectory' => $wgSQLiteDataDir,
	'trxMode' => 'IMMEDIATE',
	'flags' => 0
];
$wgJobTypeConf['default'] = [
	'class' => 'JobQueueDB',
	'claimTTL' => 3600,
	'server' => [
		'type' => 'sqlite',
		'dbname' => "{$wgDBname}_jobqueue",
		'tablePrefix' => '',
		'variables' => ['synchronous' => 'NORMAL'],
		'dbDirectory' => $wgSQLiteDataDir,
		'trxMode' => 'IMMEDIATE',
		'flags' => 0
	]
];
$wgResourceLoaderUseObjectCacheForDeps = true;

## Shared memory settings
$wgMainCacheType = CACHE_ACCEL;
$wgMemCachedServers = [];

## TODO: https://github.com/dunepedia/wiki/issues/2
$wgEnableUploads = false;
$wgUseImageMagick = true;
$wgImageMagickConvertCommand = "/usr/bin/convert";

$wgPingback = true;

$wgLanguageCode = "en";

$wgLocaltimezone = "UTC";

## TODO: https://github.com/dunepedia/wiki/issues/1
#$wgCacheDirectory = "$IP/cache";

$wgSecretKey = getenv("WG_SECRET_KEY");

# Changing this will log out all existing sessions.
# This is intended for emergencies such as a mass account compromise.
$wgAuthenticationTokenVersion = "1";

$wgRightsPage = ""; #Overrides $wgRightsUrl if specified
$wgRightsUrl = "https://creativecommons.org/licenses/by-sa/4.0/";
$wgRightsText = "Creative Commons Attribution-ShareAlike";
$wgRightsIcon = "$wgResourceBasePath/resources/assets/licenses/cc-by-sa.png";

$wgDefaultSkin = "vector";

# Enabled skins.
wfLoadSkin('Vector');
