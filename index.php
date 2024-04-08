<?php

const RESULT_WINNER = 1;
const RESULT_LOSER = -1;
const RESULT_DRAW = 0;
const RESULT_POSSIBILITIES = [RESULT_WINNER, RESULT_LOSER, RESULT_DRAW];

class Encounter {

    private int $player1;
    private int $player2;

    public function getScorePlayer1() : int {
        return $this->player1;
    }

    public function getScorePlayer2() : int {
        return $this->player2;
    }

    public function setScorePlayer1(int $score) : void {

        if($score < 0 ){
            trigger_error("Score non valide");
        }

        $this->player1 = $score;

    }

    public function setScorePlayer2(int $score) : void {
        
        if($score < 0 ){
            trigger_error("Score non valide");
        }

        $this->player2 = $score;

    }

    public function probabilityAgainst(int $levelPlayerOne, int $againstLevelPlayerTwo)
    {
        return 1/(1+(10 ** (($againstLevelPlayerTwo - $levelPlayerOne)/400)));
    }

    public function setNewLevel(int &$levelPlayerOne, int $againstLevelPlayerTwo, int $playerOneResult)
    {
        if (!in_array($playerOneResult, RESULT_POSSIBILITIES)) {
            trigger_error(sprintf('Invalid result. Expected %s',implode(' or ', RESULT_POSSIBILITIES)));
        }

        $levelPlayerOne += (int) (32 * ($playerOneResult - $this->probabilityAgainst($levelPlayerOne, $againstLevelPlayerTwo)));
    }

}

$match = new Encounter();
//Initiation du score
$match->setScorePlayer1(400);
$match->setScorePlayer2(800);

$greg = $match->getScorePlayer1();
$jade = $match->getScorePlayer2();

echo sprintf(
    'Greg à %.2f%% chance de gagner face a Jade',
    $match->probabilityAgainst($greg, $jade)*100
).PHP_EOL;

// Imaginons que greg l'emporte tout de même.
$match->setNewLevel($greg, $jade, RESULT_WINNER);
$match->setNewLevel($greg, $jade, RESULT_LOSER);

echo sprintf(
    'les niveaux des joueurs ont évolués vers %s pour Greg et %s pour Jade',
    $greg,
    $jade
);

exit(0);