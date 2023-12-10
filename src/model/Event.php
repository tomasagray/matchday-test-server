<?php


namespace Matchday\TestServer\model;

require_once 'JsonDateTime.php';

use Exception;
use FilesystemIterator;
use JsonSerializable;
use RecursiveDirectoryIterator;
use RecursiveIteratorIterator;

function get_url_path($file_path): string
{
    $pathinfo = pathinfo(dirname(__DIR__ . "/matchday-test-server"));
    $path_root = dirname($pathinfo['dirname'] . "../");
    $path = str_replace(array($path_root, DIRECTORY_SEPARATOR), array('', '/'), $file_path);
    $url = $_SERVER['REQUEST_SCHEME'] . '://' . $_SERVER['SERVER_NAME'] . ':'
        . $_SERVER['SERVER_PORT'] . $_SERVER['CONTEXT_PREFIX']
        . dirname($_SERVER['SCRIPT_NAME']);
    if (str_ends_with($url, '/')) {
        $url = substr($url, 0, -1);
    }
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
    private const PART_PATTERN = '/(\d+)-(\w+)-(\w+)-(\w+)_(\w*)(-?\w*)(\w*)\.(\w+)/';

    private string $eventId;
    private Competition $competition;
    private Team $homeTeam;
    private Team $awayTeam;
    private Season $season;
    private Fixture $fixture;
    private LocalDateTime $date;
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
        $this->eventId = UUID::create();
        $this->competition = $competition;
        $this->homeTeam = $home;
        $this->awayTeam = $away;
        $this->season = new Season();
        $this->fixture = new Fixture();
        $this->fileSources[] = new VideoFileSource();
        try {
            $this->scanParts($path);
        } catch (Exception $e) {
            exit("Error reading parts of Event! " . $e->getMessage());
        }
    }

    /**
     * @return string
     */
    public function getEventId(): string
    {
        return $this->eventId;
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
     * @return Season
     */
    public function getSeason(): Season
    {
        return $this->season;
    }

    /**
     * @return Fixture
     */
    public function getFixture(): Fixture
    {
        return $this->fixture;
    }

    /**
     * @return LocalDateTime
     */
    public function getDateTime(): LocalDateTime
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
                $this->date = LocalDateTime::fromString($groups[1][0]);
                $part_num = (int)$groups[5][0];
                $realpath = realpath($path . '/' . $file);
                $size = get_dir_size($realpath);
                $rel_path = get_url_path($realpath);
                $this->fileSources[0]->addVideoFile($rel_path, $part_num);
                $this->fileSources[0]->setFileSize($size);
                $this->fileSources[0]->setChannel("Hal9000");
                $this->fileSources[0]->setSource("DVB-S2");
                $this->fileSources[0]->setLanguages("English or Spanish?");
                $this->fileSources[0]->setResolution("1080p");
                $this->fileSources[0]->setMediaContainer("TS");
                $this->fileSources[0]->setVideoBitrate("8");
                $this->fileSources[0]->setVideoCodec("H.264");
                $this->fileSources[0]->setAudioCodec("AC3");
                $this->fileSources[0]->setDuration("90min");
                $this->fileSources[0]->setFramerate(25);
                $this->fileSources[0]->setAudioChannels(2);
                $this->fileSources[0]->setAudioBitrate(384);
            }
        }
    }

    public function jsonSerialize(): object
    {
        return (object)get_object_vars($this);
    }
}
