<?php

namespace Matchday\TestServer\model;

use JsonSerializable;


class VideoFileSource implements JsonSerializable
{

    private string $fileSrcId;
    private array $videoFilePacks;
    private int $fileSize;

    /**
     * VideoFileSource constructor.
     */
    public function __construct()
    {
        $this->fileSrcId = UUID::create();
        $this->videoFilePacks = [new VideoFilePack()];
    }

    public function addVideoFile($videoFile, $part): void
    {
        $this->videoFilePacks[0]->addVideoFile($videoFile, $part);
    }

    /**
     * @return string
     */
    public function getFileSrcId(): string
    {
        return $this->fileSrcId;
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
