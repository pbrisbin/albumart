#!/usr/bin/env php
<?php require_once('lib/AWSSoapClient.php');

function usage() {
    echo 'usage: albumart -a[--artist=] <artist> -b[--album=] <album>'.PHP_EOL;
    exit();
}

function get_album_art($_artist, $_album) {
    $wsdl = 'http://webservices.amazon.com/AWSECommerceService/AWSECommerceService.wsdl?';

    $options['aws_config'] = 'conf/aws.ini';

    $request['Request'] = array(
        'SearchIndex'   => 'Music',
        'Artist'        => $_artist,
        'Title'         => $_album,
        'ResponseGroup' => 'Images'
    );

    $client = new AWSSoapClient($wsdl, $options);
    $result = $client->ItemSearch($request);

    if (isset($result->Items->Item)) {
        foreach ($result->Items->Item as $item) {
            if (isset($item->LargeImage->URL)) {
                return $item->LargeImage->URL;
            }
        }
    }

    return false;
}

function parse_options() {
    $shortopts  = 'a:b:';
    $longopts   = array(
        'artist:',
        'album:'
    );

    $retval = array();

    $opts = getopt($shortopts, $longopts);

    if (isset($opts['a'])) {
        $retval[0] = $opts['a'];
    }
    else if (isset($opts['artist'])) {
        $retval[0] = $opts['artist'];
    }
    else {
        usage();
    }

    if (isset($opts['b'])) {
        $retval[1] = $opts['b'];
    }
    else if (isset($opts['album'])) {
        $retval[1] = $opts['album'];
    }
    else {
        usage();
    }

    return $retval;
}

list($artist,$album) = parse_options();
$url = get_album_art($artist, $album);
echo $url ? $url.PHP_EOL : 'no results found.'.PHP_EOL;

?>
