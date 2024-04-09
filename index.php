<?php

declare(strict_types=1);

spl_autoload_register(static function (string $fqcn) {

    $path = sprintf("%s.php", str_replace(["App","\\"],["src","/"], $fqcn));

    require_once($path);

});
//Initiation du score

use App\MatchMaker\Lobby;
use App\MatchMaker\Player\Player;

$greg = new Player("greg", 400);
$jade = new Player("jade", 476);

$lobby = new Lobby();
$lobby->addPlayers($greg, $jade);

var_dump($lobby->findOpenents($lobby->queuingPlayers[0]));

exit(0);

