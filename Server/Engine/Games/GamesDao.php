<?php
  require_once $_SERVER['DOCUMENT_ROOT']."/CardGame/Server/DB/connect.php";

  class GamesDao{

    private $gamesFolder = "../../CurrentGamesFiles/";

    public function __construct(){}

    private function generateGameId(){
      $randId = substr(md5(microtime()),0,15);
      $game = $this->getGameById($randId);
      while($game != null){
        $randId = substr(md5(microtime()),0,15);
        $game = $this->getGameById($randId);
      }
      return $randId;
    }

    public function getAllGames(){
      $gameFilePath = $this->gamesFolder."/Game1.json";
      $gamesFile = fopen($gameFilePath, "r");
      $games = json_decode(fread($gamesFile,filesize($gameFilePath)),true);
      return $games;
    }

    public function getGameById($gameId){
      $gameFilePath = $this->gamesFolder.$gameId.".json";
      try{
        $gamesFile = @fopen($gameFilePath, "r");
        if (!$gamesFile) {
          throw new Exception('No such file');
        }
        $game = json_decode(fread($gamesFile,filesize($gameFilePath)),true);
      } catch(Exception $e){
        $game= null;
      }

      return $game;
    }

    public function createGame(){
      $newGameId = $this->generateGameId();
      $gameFilePath = $this->gamesFolder."/".$newGameId.".json";
      $gamesFile = fopen($gameFilePath, "w");
      $game = array('Message' => "Yo2");
      fwrite($gamesFile,json_encode($game));
      fclose($gamesFile);
      //return $game;
    }



  }

  $gamesDao = new GamesDao();
  $response = $gamesDao->getGameById("8743eqc4rq3");
  $gamesDao->createGame();
  echo json_encode($response);


?>
