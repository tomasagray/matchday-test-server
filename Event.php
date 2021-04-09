<?php


namespace matchday;


use DateTime;
use Exception;
use JsonSerializable;

function get_url_path($file_path): string
{
    $pathinfo = pathinfo(realpath(__FILE__));
    $path_root = $pathinfo['dirname'];
    $path = str_replace(array($path_root, DIRECTORY_SEPARATOR), array('', '/'), $file_path);
    $url = $_SERVER['REQUEST_URI'];
    return substr($url,0, -1).$path;
}

class Event implements JsonSerializable
{
    private const PART_PATTERN = '/(\d+)-(\w+)-(\w+)-(\w+)_(\d{1})(-?\d*).(\w+)/';

    private Competition $competition;
    private Team $home;
    private Team $away;
    private string $path;
    private DateTime $timestamp;
    private array $parts;

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
        $this->home = $home;
        $this->away = $away;
        $this->path = $path;
        try {
            $this->scanParts();
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
    public function getHome(): Team
    {
        return $this->home;
    }

    /**
     * @return Team
     */
    public function getAway(): Team
    {
        return $this->away;
    }

    /**
     * @return string
     */
    public function getPath(): string
    {
        return $this->path;
    }

    /**
     * @return DateTime
     */
    public function getTimestamp(): DateTime
    {
        return $this->timestamp;
    }

    /**
     * @return array
     */
    public function getParts(): array
    {
        return $this->parts;
    }

    /**
     * @throws Exception
     */
    private function scanParts(): void
    {
        $files = scandir($this->path);
        foreach ($files as $file) {
            $groups = array();
            if (preg_match_all(self::PART_PATTERN, $file, $groups) > 0) {
                $date = $groups[1][0];
                $part_num = (int)$groups[5][0];
                $this->timestamp = new DateTime($date);
                $realpath = realpath($this->path . '/' . $file);
                $rel_path = get_url_path($realpath);
                $this->parts[$part_num] = $rel_path;
            }
        }
    }

    public function jsonSerialize(): object
    {
        return (object) get_object_vars($this);
    }
}
