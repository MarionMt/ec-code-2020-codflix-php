<?php

require_once( 'model/media.php' );

/***************************
* ----- LOAD HOME PAGE -----
***************************/

function mediaPage() {
  if (isset($_GET['media'])):
    $media = Media::mediaById($_GET['media']);
    $serie = Media::getSerieById($_GET['media']);
    $mediaType = Media::mediaTypeById($media["genre_id"]);
    $type = $media["type"];
    $name = $mediaType["name"];
    $release = date('d-m-Y', strtotime($media["release_date"]));
    $summary = $media["summary"];
    $id = $media["id"];
    if ($media["type"] === "film"): 
      $movie = Media::getmovie($_GET['media']);
      $duration = date('H\hi', strtotime($movie["duration"]));
      
    else: 
      $season = Media::getSeasonById($_GET['media']);;
      $episode = Media::getEpisodeById($_GET['media']);
      $episodeUrl = Media::getEpisodeUrl($_GET['season'], $_GET['episode']);
      $episodeDuration = Media::getEpisodeDuration($_GET['season'], $_GET['episode']);
      $duration = date('H\hi', strtotime($episodeDuration["duration"]));
    endif;
    require('view/mediaDetailsView.php');

  else:
    $media = Media::mediaById($_GET['media']);
    $release = date('d-m-Y', strtotime($media["release_date"]));
    $search = isset($_GET['title']) ? $_GET['title'] : null;
    $medias = Media::filterMedias($search);
    require('view/mediaListView.php');
  endif;
}