<?php

namespace Matchday\TestServer\model;

use JsonSerializable;


class VideoFileSource implements JsonSerializable
{
    private array $videoFilePacks;
    private int $fileSize;
    private string $channel;
    private string $source;
    private string $languages;
    private string $resolution;
    private string $mediaContainer;
    private string $bitrate;
    private string $videoCodec;
    private string $audioCodec;
    private string $duration;

    /**
     * VideoFileSource constructor.
     */
    public function __construct()
    {
        $this->videoFilePacks = [new VideoFilePack()];
    }

    public function addVideoFile($videoFile, $part): void
    {
        $this->videoFilePacks[0]->addVideoFile($videoFile, $part);
    }

    /**
     * @return array
     */
    public function getVideoFilePacks(): array
    {
        return $this->videoFilePacks;
    }

    /**
     * @return int
     */
    public function getFileSize(): int
    {
        return $this->fileSize;
    }

    /**
     * @param int $fileSize
     */
    public function setFileSize(int $fileSize): void
    {
        $this->fileSize = $fileSize;
    }

    /**
     * @param string $channel
     */
    public function setChannel(string $channel): void
    {
        $this->channel = $channel;
    }

    /**
     * @param string $source
     */
    public function setSource(string $source): void
    {
        $this->source = $source;
    }

    /**
     * @param string $languages
     */
    public function setLanguages(string $languages): void
    {
        $this->languages = $languages;
    }

    /**
     * @param string $resolution
     */
    public function setResolution(string $resolution): void
    {
        $this->resolution = $resolution;
    }

    /**
     * @param string $mediaContainer
     */
    public function setMediaContainer(string $mediaContainer): void
    {
        $this->mediaContainer = $mediaContainer;
    }

    /**
     * @param string $bitrate
     */
    public function setBitrate(string $bitrate): void
    {
        $this->bitrate = $bitrate;
    }

    /**
     * @param string $videoCodec
     */
    public function setVideoCodec(string $videoCodec): void
    {
        $this->videoCodec = $videoCodec;
    }

    /**
     * @param string $audioCodec
     */
    public function setAudioCodec(string $audioCodec): void
    {
        $this->audioCodec = $audioCodec;
    }

    /**
     * @param string $duration
     */
    public function setDuration(string $duration): void
    {
        $this->duration = $duration;
    }

    /**
     * @inheritDoc
     */
    public function jsonSerialize(): object
    {
        $files_bk = $this->videoFilePacks;
        $this->videoFilePacks = array_values($this->videoFilePacks);
        $serialized = (object)get_object_vars($this);
        $this->videoFilePacks = $files_bk;
        return $serialized;
    }
}
