<?php


namespace matchday;

require_once 'JsonDateTime.php';

use DateTime;
use Exception;
use JsonSerializable;

function get_url_path($file_path): string
{
    $pathinfo = pathinfo(realpath(__FILE__));
    $path_root = $pathinfo['dirname'];
    $path = str_replace(array($path_root, DIRECTORY_SEPARATOR), array('', '/'), $file_path);
    $url = $_SERVER['REQUEST_SCHEME'].'://' . $_SERVER['SERVER_NAME'] . $_SERVER['CONTEXT_PREFIX'];
    return $url.$path;
}

class Event implements JsonSerializable
{
    private const PART_PATTERN = '/(\d+)-(\w+)-(\w+)-(\w+)_(\d{1})(-?\d*).(\w+)/';

    private Competition $competition;
    private Team $homeTeam;
    private Team $awayTeam;
    private JsonDateTime $date;
    private array $fileSources;

    /**
     * Event constructor.
     * @param Competition $competition
     * @param Team $home
     * @param Team $away
     * @param DateTime $timestamp
     */
    public function __construct(Competition $competition, Team $home, Team $away, string $path)
    {
        $this->competition = $competition;
        $this->homeTeam = $home;
        $this->awayTeam = $away;
        $this->fileSources[] = new EventFileSource();
        try {
            $this->scanParts($path);
        } catch (Exception $e) {
            exit("Error reading parts of Event! ".$e->getMessage());
        }
    }

    /**
     * @return Competition
     */
    public function getCompetition(): Competition
    {
        return $this->competition;
    }

    /**
     * @return Team
     */
    public function getHomeTeam(): Team
    {
        return $this->homeTeam;
    }

    /**
     * @return Team
     */
    public function getAwayTeam(): Team
    {
        return $this->awayTeam;
    }

    /**
     * @return DateTime
     */
    public function getDate(): DateTime
    {
        return $this->date;
    }

    /**
     * @throws Exception
     */
    private function scanParts(string $path): void
    {
        $files = scandir($path);
        foreach ($files as $file) {
            $groups = array();
            if (preg_match_all(self::PART_PATTERN, $file, $groups) > 0) {
                $date = $groups[1][0];
                $part_num = (int)$groups[5][0];
                $this->date = new JsonDateTime($date); //date_format(new DateTime($date), 'Y-m-d H:m:s');
                $realpath = realpath($path . '/' . $file);
                $rel_path = get_url_path($realpath);
                $this->fileSources[0]->addEventFile($rel_path, $part_num);
            }
        }
//        var_dump($this->fileSource);
    }

    public function jsonSerialize(): object
    {
        return (object) get_object_vars($this);
    }
}
