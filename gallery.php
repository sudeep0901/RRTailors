<!DOCTYPE html>
<html lang="en-US">
<head>
    <meta charset="UTF-8" />
    <title>Different background and text colours for each photo</title>
    <link rel="stylesheet" type="text/css" media="all" href="css/gallery/font-awesome.min.css" />
    <link rel="stylesheet" type="text/css" media="all" href="css/gallery/jgallery.min.css" />
    <script type="text/javascript" src="js/gallery/js/jquery-2.0.3.min.js"></script>
    <script src="http://code.jquery.com/jquery-2.0.3.min.js"></script>

    <script type="text/javascript" src="js/gallery/js/jgallery.min.js"></script>
    <script type="text/javascript" src="js/gallery/js/tinycolor-0.9.16.min.js"></script>
    <script type="text/javascript" src="js/gallery/js/touchswipe.min.js"></script>
</head>
<body style="width: 900px; margin: 100px auto; height: auto;">
<script type="text/javascript">
$( function() {
    $( '#gallery' ).jGallery();
} );
</script>
<div id="gallery">
    <div class="album" data-jgallery-album-title="Album 1">
        <a href="images/gallery/images/large/1.jpg"><img src="images/gallery/images/thumbs/1.jpg" alt="Photo 1" /></a>
        <a href="images/gallery/images/large/2.jpg"><img src="images/gallery/images/thumbs/2.jpg" alt="Photo 2" /></a>
        <a href="images/gallery/images/large/3.jpg"><img src="images/gallery/images/thumbs/3.jpg" alt="Photo 3" /></a>
    </div>
    <div class="album" data-jgallery-album-title="Album 2">
        <a href="images/gallery/images/large/4.jpg"><img src="images/gallery/images/thumbs/4.jpg" alt="Photo 4" /></a>
        <a href="images/gallery/images/large/5.jpg"><img src="images/gallery/images/thumbs/5.jpg" alt="Photo 5" /></a>
        <a href="images/gallery/images/large/6.jpg"><img src="images/gallery/images/thumbs/6.jpg" alt="Photo 6" /></a>
    </div>
</div>
</body>
</html>