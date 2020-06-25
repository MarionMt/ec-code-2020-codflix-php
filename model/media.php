<?php

require_once( 'database.php' );

class Media {

  protected $id;
  protected $genre_id;
  protected $title;
  protected $type;
  protected $status;
  protected $release_date;
  protected $summary;
  protected $trailer_url;

  public function __construct( $media ) {

    $this->setId( isset( $media->id ) ? $media->id : null );
    $this->setGenreId( $media->genre_id );
    $this->setTitle( $media->title );
  }

  /***************************
  * -------- SETTERS ---------
  ***************************/

  public function setId( $id ) {
    $this->id = $id;
  }

  public function setGenreId( $genre_id ) {
    $this->genre_id = $genre_id;
  }

  public function setTitle( $title ) {
    $this->title = $title;
  }

  public function setType( $type ) {
    $this->type = $type;
  }

  public function setStatus( $status ) {
    $this->status = $status;
  }

  public function setReleaseDate( $release_date ) {
    $this->release_date = $release_date;
  }

  /***************************
  * -------- GETTERS ---------
  ***************************/

  public function getId() {
    return $this->id;
  }

  public function getGenreId() {
    return $this->genre_id;
  }

  public function getTitle() {
    return $this->title;
  }

  public function getType() {
    return $this->type;
  }

  public function getStatus() {
    return $this->status;
  }

  public function getReleaseDate() {
    return $this->release_date;
  }

  public function getSummary() {
    return $this->summary;
  }

  public function getTrailerUrl() {
    return $this->trailer_url;
  }

  /***************************
  * -------- GET LIST --------
  ***************************/

  public static function filterMedias( $title ) {

    // Open database connection
    $db   = init_db();
    $req  = $db->prepare( "SELECT * FROM media WHERE title LIKE ".'"%' . $title . '%"' . " ORDER BY release_date DESC" );
    $req->execute();

    // Close database connection
    $db   = null;

    return $req->fetchAll();

  }

  /***************************
  * -------- GET MEDIA ------
  ***************************/

  public static function mediaById($id) {
    // Open database connection
    $db = init_db();
    $req = $db->prepare("SELECT * FROM media WHERE id = " . $id);
    $req->execute();

    // Close database connection
    $db = null;
    return $req->fetch();
  }

  //get type 
  public static function mediaTypeById($id) {
    // Open database connection
    $db = init_db();
    $req = $db->prepare("SELECT * FROM genre WHERE id = " . $id);
    $req->execute();

    // Close database connection
    $db = null;
    return $req->fetch();
  }

  /***************************
  * ------ GET MOVIE ------
  ***************************/

  public static function getMovie( $movie ) {
    // Open database connection
    $db = init_db();
    $req = $db->prepare("SELECT * FROM movies WHERE  movie_id = " . $movie );
    $req->execute();
      
    // Close database connection
    $db = null;
    return $req->fetch();
  }

  /***************************
  * -------- GET SERIE ------
  ***************************/

  public static function getSerieById($serie) {
    // Open database connection
    $db = init_db();
    $req = $db->prepare("SELECT * FROM series WHERE serie_id = " . $serie);
    $req->execute();

    // Close database connection
    $db = null;
    return $req->fetchAll();
  }

  public static function getSerieBySeason($season) {
    // Open database connection
    $db = init_db();
    $req = $db->prepare("SELECT * FROM series WHERE season = " . $season);
    $req->execute();

    // Close database connection
    $db = null;
    return $req->fetchAll();
  }

  //get season
  public static function getSeasonById( $season ) {
    // Open database connection
    $db = init_db();
    $req = $db->prepare("SELECT season FROM series WHERE serie_id = " . $season . " GROUP BY season");
    $req->execute();

    // Close database connection
    $db = null;
    return $req->fetchAll();
  }

  //get episode
  public static function getEpisodeById( $season ) {
    // Open database connection
    $db = init_db();
    $req = $db->prepare("SELECT episode FROM series WHERE serie_id = " . $season . " GROUP BY episode");
    $req->execute();

    // Close database connection
    $db = null;
    return $req->fetchAll();
  }

  //get episode URL
  public static function getEpisodeUrl( $season, $episode ) {
    // Open database connection
    $db = init_db();
    $req = $db->prepare("SELECT url_episode FROM series WHERE season = " . $season . " AND episode=" . $episode );
    $req->execute();

    // Close database connection
    $db = null;
    return $req->fetch();
  }
}
