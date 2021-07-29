<?php


namespace matchday;

require_once 'JsonDateTime.php';

use DateTime;
use Exception;
use FilesystemIterator;
use JsonSerializable;
use RecursiveDirectoryIterator;
use RecursiveIteratorIterator;

function get_url_path($file_path): string
{
    $pathinfo = pathinfo(realpath(__FILE__));
    $path_root = $pathinfo['dirname'];
    $path = str_replace(array($path_root, DIRECTORY_SEPARATOR), array('', '/'), $file_path);
    $url = $_SERVER['REQUEST_SCHEME'] . '://' . $_SERVER['SERVER_NAME'] . ':'
            . $_SERVER['SERVER_PORT'] . $_SERVER['CONTEXT_PREFIX'] . ''
            . dirname($_SERVER['SCRIPT_NAME']);
    return $url . $path;
}

function get_dir_size($real_path): int
{
    $bytesTotal = 0;
    $path = dirname($real_path);
    if ($path !== '' && file_exists($path)) {
        foreach (new RecursiveIteratorIterator(new RecursiveDirectoryIterator($path, FilesystemIterator::SKIP_DOTS)) as $object) {
            $bytesTotal += $object->getSize();
        }
    }
    return $bytesTotal;
}

class Event implements JsonSerializable
{
    private const PART_PATTERN = '/(\d+)-(\w+)-(\w+)-(\w+)_([\w]*)(-?[\w]*)(\w*)\.(\w+)/';

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
     * @param string $path
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
            exit("Error reading parts of Event! " . $e->getMessage());
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
     * @return array
     */
    public function getFileSources(): array
    {
        return $this->fileSources;
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
                $size = get_dir_size($realpath);
                $rel_path = get_url_path($realpath);
                $this->fileSources[0]->addEventFile($rel_path, $part_num);
                $this->fileSources[0]->setFileSize($size);
            }
        }
    }

    public function jsonSerialize(): object
    {
        return (object)get_object_vars($this);
    }
}
