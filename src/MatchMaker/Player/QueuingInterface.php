<?php

declare(strict_types=1);

namespace App\MatchMaker\Player;

interface QueuingInterface {

    public function getRange();

    public function upgradeRange();

}