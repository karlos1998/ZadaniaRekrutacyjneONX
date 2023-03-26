<?php


class RankingTable {
    private $players = [];
    private $scores = [];

    public function __construct(array $players) {
        $this->players = $players;
    }

    public function recordResult(string $player, int $points) {
        if(in_array($player, $this->players))
        {
            $score = $this->scores[$player] ?? array(
                'score' => 0,
                'games' => 0,
                'name' => $player
            );
            $score['score'] += $points;
            $score['games']++;

            $this->scores[$player] = $score;
        }
        else
        {
            echo "Brak gracza $player." . PHP_EOL;
        }
    }

    private function sortPlayers()
    {
        $sorted = $this->scores;
        usort($sorted, function($a, $b) {
            if ($a["score"] == $b["score"]) {
                return $a["games"] - $b["games"];
            }
            return $b["score"] - $a["score"];
        });
        return $sorted;
    }

    public function playerRank(int $rank)
    {
        $sorted = $this->sortPlayers();
        //var_dump($this->scores);
        if($rank < 1 || $rank > count($sorted)) return null;
        return $sorted[$rank - 1]['name'];
    }

}

$table = new RankingTable(array('Jan', 'Maks', 'Monika'));
$table->recordResult('Jan', 2);
$table->recordResult('Maks', 3);
$table->recordResult('Monika', 5);
echo $table->playerRank(1); //Monika

echo PHP_EOL;


$table = new RankingTable(array('Jan', 'Maks', 'Monika'));
$table->recordResult('Jan', 2);
$table->recordResult('Jan', 2);
$table->recordResult('Monika', 4);
$table->recordResult('Maks', 4);
echo $table->playerRank(1); //Monika

/**
 * Wszyscy gracze mają taki sam wynik. 
 * Jednak Maks i Monika rozegrali mniej gier niż Jan, 
 * a ponieważ Monika znajduje się przed Maks na liście graczy, 
 * jest on sklasyfikowany jako pierwszy. 
 * Dlatego powyższy kod powinien zwrócić "Monika".
 */