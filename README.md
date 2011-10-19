# Album Art

### Description

A short PHP script to query Amazon Web Services for the large cover 
image of the passed artist and album.

The script returns the direct url to the image for easy `wget`ting.

**Note: You must have an AWS account before using this script.**

An [AWS][aws] account is free and easy to setup.

### Usage

    $ albumart.php
    usage: albumart <options>

        options:
            -a, --artist=ARTIST  artist name to search for
            -b, --album=ALBUM    album name to search for


    $ albumart.php -a 'Red Hot Chili Peppers' -b 'Californication'
    http://ecx.images-amazon.com/images/I/61P2to5ZL8L.jpg


    $ albumart.php -a 'blahblah' -b 'blahblah'
    no results found.

### Setup

The following environment variables must be exported or otherwise set 
before calling the script. It's how it finds its library and 
authenticates the AWS request.

1. `AWS_LIB` - full path to the directory containing AWSSoapClient.php
2. `AWS_CERT_FILE` - full path to your cert-\* file as downloaded from 
   your aws dashboard
3. `AWS_PRIVATE_KEY_FILE` - full path to your pk-\* file as downloaded 
   from your aws dashboard

### Full Disclosure

This script contains my Associate Tag. Recently, AWS required this as a 
parameter to all requests (breaking this script). Rather than make 
yet-another-environment-variable or commandline option, I chose to just 
setup an associate tag for my site and hardcode it in the script.

What does this mean?

I may make 0.00000001 cents each time you use this script. To be honest, 
I have no idea what the figures are or how it works. I don't really care 
if this results in me making money (unless it's a lot, which I assume 
it's not).

Bottom line -- if it matters to you, get your own associate tag and 
update line 24 in `albumart.php`.

[aws]: http://aws.amazon.com "aws at amazon"
