<?php



  class GamesUtils{

    public function __construct(){}

    public function newGameJson(){
      $players = array();
      $history = array();
      $gameArray = array('History' => $history, 'Players' => $players, 'Pending' => 1, 'Turn' => 0,
        'GameStatus' => "The game is in progress", 'MatchWinner' => "Nobody yet"
     );
      return $gameArray;
    }

  }






?>
