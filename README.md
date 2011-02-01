# Album Art

### Description

A short PHP script to query Amazon Web Services for the large cover 
image of a given Artist/Album.

The script returns the direct url to the image for easy `wget`ting.

### Usage

    $ ./albumart.php -a 'Red Hot Chili Peppers' -b 'Californication'
    http://ecx.images-amazon.com/images/I/61P2to5ZL8L.jpg

### Notes

The conf and lib directories are expected to be in the same place as the 
script and the same place that you're currently executing the script in. 
use the `--conf` and `--lib` arguments if this is not convenient.

The ./conf directory hosted here contains my AWS Account info (Ids and 
Keys). It's not a huge deal if you use them but it's super easy to sign 
up for your own account. Please do.
