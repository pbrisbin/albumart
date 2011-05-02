#!/usr/bin/env php
<?php 

/* a help message. */
function usage() {
    $message = <<<EOF
usage: albumart.php -a <artist> -b <album>

    options:
        -a, --artist=ARTIST  artist name to search for
        -b, --album=ALBUM    album name to search for


EOF;

    echo $message;
    exit();
}

/* fetch the large cover url for the given artist and album */
function get_album_art($_artist, $_album) {
    $wsdl = 'http://webservices.amazon.com/AWSECommerceService/AWSECommerceService.wsdl?';

    $request['Request'] = array(
        'SearchIndex'   => 'Music',
        'Artist'        => $_artist,
        'Title'         => $_album,
        'ResponseGroup' => 'Images'
    );

    /* silence errors with @ */
    @$client = new AWSSoapClient($wsdl);
    @$result = $client->ItemSearch($request);

    if (isset($result->Items->Item)) {
        foreach ($result->Items->Item as $item) {
            if (isset($item->LargeImage->URL)) {
                return $item->LargeImage->URL;
            }
        }
    }

    return false;
}

/* parse command-line options */
function parse_options() {
    global $artist,$album;

    $shortopts = 'a:b:';
    $longopts  = array(
        'artist:',
        'album:',
    );

    $opts = getopt($shortopts, $longopts);

    if (isset($opts['a'])) {
        $artist = $opts['a'];
    }
    else if (isset($opts['artist'])) {
        $artist = $opts['artist'];
    }
    else {
        usage(); // required
    }

    if (isset($opts['b'])) {
        $album = $opts['b'];
    }
    else if (isset($opts['album'])) {
        $album = $opts['album'];
    }
    else {
        usage(); // required
    }
}

$artist = '';
$album  = '';

/* mandatory env vars */
foreach (array('AWS_CERT_FILE', 'AWS_PRIVATE_KEY_FILE') as $env_var) {
    if (empty($_SERVER[$env_var])) {
        echo 'required environment variable '.$env_var.' is not set.'.PHP_EOL;
        echo 'please define this variable and try again.'.PHP_EOL;
        exit();
    }
}

/* set lib */
$env_var = 'AWS_LIB';
if (!empty($_SERVER[$env_var])) {
    $lib = $_SERVER[$env_var];
}
else {
    $lib = 'lib';
}

/* commandline flags */
parse_options();

/* see the README for authentication notes */
require_once($lib.'/AWSSoapClient.php');

$url = get_album_art($artist, $album);
echo $url ? $url : 'no results found.';
echo PHP_EOL;

?>
