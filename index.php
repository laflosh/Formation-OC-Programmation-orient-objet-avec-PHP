<?php

const RESULT_WINNER = 1;
const RESULT_LOSER = -1;
const RESULT_DRAW = 0;
const RESULT_POSSIBILITIES = [RESULT_WINNER, RESULT_LOSER, RESULT_DRAW];

class Encounter {

    public int $player1;
    public int $player2;

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

$match->player1 = 400;
$match->player2 = 800;

echo sprintf(
    'Greg à %.2f%% chance de gagner face a Jade',
    $match->probabilityAgainst($match->player1, $match->player2)*100
).PHP_EOL;

// Imaginons que greg l'emporte tout de même.
$match->setNewLevel($match->player1, $match->player2, RESULT_WINNER);
$match->setNewLevel($match->player1, $match->player2, RESULT_LOSER);

echo sprintf(
    'les niveaux des joueurs ont évolués vers %s pour Greg et %s pour Jade',
    $match->player1,
    $match->player2
);

exit(0);