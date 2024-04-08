<?php

class Encounter {

    public const RESULT_WINNER = 1;
    public const RESULT_LOSER = -1;
    public const RESULT_DRAW = 0;
    public const RESULT_POSSIBILITIES = [self::RESULT_WINNER, self::RESULT_LOSER, self::RESULT_DRAW];

    public static function probabilityAgainst(Player $playerOne, Player $playerTwo)
    {
        return 1/(1+(10 ** (($playerTwo->level - $playerOne->level)/400)));
    }

    public static function setNewLevel(Player $playerOne, Player $playerTwo, int $playerOneResult)
    {
        if (!in_array($playerOneResult, self::RESULT_POSSIBILITIES)) {
            trigger_error(sprintf('Invalid result. Expected %s',implode(' or ', self::RESULT_POSSIBILITIES)));
        }

        $playerOne->level += (int) (32 * ($playerOneResult - self::probabilityAgainst($playerOne, $playerTwo)));
    }

}

class Player {

    private int $level;

    public function getLevel() : int {
        return $this->level;
    }

    public function setLevel(int $level): void
    {
        
        self::checkLevel($level);

        $this->level = $level;

    }

    public function __construct(int $level){

        self::checkLevel($level);

        $this->level = $level;

    }

    public static function checkLevel($level){

        if($level < 0 ){

            trigger_error("Score non valide");

        }

        return true;
    }

}


//Initiation du score
$greg = new Player(400);
$jade = new Player(800);

echo sprintf(
    'Greg à %.2f%% chance de gagner face a Jade',
    Encounter::probabilityAgainst($greg, $jade)*100
).PHP_EOL;

// Imaginons que greg l'emporte tout de même.
Encounter::setNewLevel($greg, $jade, Encounter::RESULT_WINNER);
Encounter::setNewLevel($greg, $jade, Encounter::RESULT_LOSER);

echo sprintf(
    'les niveaux des joueurs ont évolués vers %s pour Greg et %s pour Jade',
    $greg->getLevel(),
    $jade->getLevel()
);

exit(0);