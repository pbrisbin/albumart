# Album Art

### Description

A short PHP script to query Amazon Web Services for the large cover 
image of a given Artist/Album.

The script returns the direct url to the image for easy `wget`ting.

### Usage

    $ ./albumart.php -a 'Red Hot Chili Peppers' -b 'Californication'
    http://ecx.images-amazon.com/images/I/61P2to5ZL8L.jpg

### Notes

You must either execute the script in the same directory as ./conf and 
./lib or change the paths in the script.

The ./conf directory available here contains my AWS Account info (Ids 
and Keys). It's not a huge deal if you use them but it's super easy to 
sign up for your own account. Please do.
