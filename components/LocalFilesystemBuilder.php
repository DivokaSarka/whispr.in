<?php

namespace app\components;

use League\Flysystem\Adapter\Local;
use League\Flysystem\Filesystem;
use trntv\filekit\filesystem\FilesystemBuilderInterface;
use yii\base\Object;

class LocalFilesystemBuilder extends Object implements FilesystemBuilderInterface
{
    /**
     * @var
     */
    public $path;

    /**
     * @return Filesystem
     */
    public function build()
    {
        $adapter = new Local(\Yii::getAlias($this->path));

        return new Filesystem($adapter);
    }
}