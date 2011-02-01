#!/usr/bin/env php
<?php 

/* a help message. */
function usage() {
    $message = <<<EOF
usage: albumart <options>

    required options

        -a, --artist=ARTIST  artist name to search for
        -b, --album=ALBUM    album name to search for

    optional options:

        --lib=DIR            library files location if not ./lib


EOF;

    echo $message;
    exit();
}

/* fetch the large cover url for the give artist and album. use the aws 
 * configuration in conf/aws.ini. */
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
    /* set global vars */
    global $artist,$album,$lib;

    $shortopts  = 'a:b:';
    $longopts   = array(
        'artist:',
        'album:',
        'lib:'
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

    /* optional */
    if (isset($opts['lib'])) {
        $lib = $opts['lib'];
    }
}

$artist = '';
$album  = '';

/* default */
$lib = 'lib';

/* commandline flags */
parse_options();

/* see the README for authentication notes */
require_once($lib.'/AWSSoapClient.php');

$url = get_album_art($artist, $album);
echo $url ? $url.PHP_EOL : 'no results found.'.PHP_EOL;

?>
