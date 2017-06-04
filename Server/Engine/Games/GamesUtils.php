<?php



  class GamesUtils{

    public function __construct(){}

    public function newGameJson(){
      $players = array();
      $gameArray = array('Players' => $players, 'Pending' => 1, 'Turn' => 0);
      return $gameArray;
    }

  }






?>
