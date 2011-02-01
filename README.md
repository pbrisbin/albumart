# AlbumArt

### Description

A short PHP script to query Amazon Web Services for the large cover 
image of a given Artist/Album.

The script returns the direct url to the image for easy `wget`ting.

*Note: You must have an AWS account before using this script.*

### Usage

    $ ./albumart.php -a 'Red Hot Chili Peppers' -b 'Californication'
    http://ecx.images-amazon.com/images/I/61P2to5ZL8L.jpg

### Lib

The script expects ./lib/AWSSoapClient.php from the perspective of where 
you are when running it. 

You can also use the `--lib` option to specify an alternate path to the 
directory containing AWSSoapClient.php.

### AWS Authentication

An [AWS][aws] account is free and easy to setup.

The AWSSoapClient lib checks for authentication information in the 
following order:

1. /etc/aws.conf
2. $HOME/.aws/aws.conf
3. Environment variables

Each definition will override those that came before.

The conf files should be normal php ini files, defining `cert_file` and 
`private_key_file` as paths to your cert-\* and pk-\* files which you 
can download from your aws dashboard.

The analogous environment variables are `AWS_CERT_FILE` and 
`AWS_PRIVATE_KEY_FILE`.

[aws]: http://aws.amazon.com "aws at amazon"
