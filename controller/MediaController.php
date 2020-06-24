<?php

require_once( 'model/media.php' );

/***************************
* ----- LOAD HOME PAGE -----
***************************/

function mediaPage() {
  if (isset($_GET['media'])) {
    $media = Media::mediaById($_GET['media']);
    $mediaType = Media::mediaTypeById($media["genre_id"]);
    require('view/mediaDetailsView.php');
  }
  else {
    $search = isset($_GET['title']) ? $_GET['title'] : null;
    $medias = Media::filterMedias($search);
    require('view/mediaListView.php');
  }
}