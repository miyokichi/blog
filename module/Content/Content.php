<?php

namespace module\Content;

require_once __DIR__ . '/MarkdownObject.php';

class Content extends MarkdownObject
{
    public $contentPath;

    /**
     * @param $contentPath コンテンツのサーバールートからのパス。
     */
    public function __construct($contentPath)
    {
        $pathParam = explode('/', $contentPath);
        $markdownPath = $contentPath . $pathParam[count($pathParam)-2] . '.md';
        parent::__construct($markdownPath);
        $this->contentPath = $contentPath;
    }

    /**
     * コンテンツへのアクセスパスを取得
     */
    public function GetAccessPath(){
        return '/' . \str_replace(\Setting::ROOT_CONTENT_PATH,'', $this->contentPath);
    }

    /**
     * 子コンテンツパスを返す。
     * @return array $childContentPaths
     */
    public function GetChildContentPaths()
    {
        $childContentPaths = glob($this->contentPath . '*/');
        return $childContentPaths;
    }

    /**
     * 同階層のコンテンツパスを返す
     * @return array $brotherContentPaths
     */
    public function GetBrotherContentPaths()
    {
        $parentContentPath = $this->GetParentContentPath();
        $brotherContentPaths = glob($parentContentPath . '*/');
        return $brotherContentPaths;
    }

    /**
     * ひとつ前のコンテンツパスを返す
     */
    public function GetPreviewContentPath(){
        $previewContentPath = false;
        $brotherContentPaths = $this->GetBrotherContentPaths();
        foreach ($brotherContentPaths as $brotherContentPath) {
            if($brotherContentPath == $this->contentPath){
                $previewContentPath = prev($brotherContentPaths);
                break;
            }
            next($brotherContentPaths);
        }
        return $previewContentPath;
    }

     /**
      * 一つ後のコンテンツパスを返す
      */
      public function GetNextContentPath(){
        $nextContentPath = false;
        $brotherContentPaths = $this->GetBrotherContentPaths();
        foreach ($brotherContentPaths as $brotherContentPath) {
            if($brotherContentPath == $this->contentPath){
                $nextContentPath = next($brotherContentPaths);
                break;
            }
            next($brotherContentPaths);
        }
        return $nextContentPath;
      }

    /**
     * 親コンテンツのパスを返す。
     * @return string $parentContentPath
     */
    public function GetParentContentPath()
    {
        $parentContentPath = false;
        if ($this->contentPath != \Setting::ROOT_CONTENT_PATH) {
            $pathParamater = explode('/', $this->contentPath);
            for ($i=0; $i<(count($pathParamater)-2); $i++) {
                $parentContentPath = $parentContentPath . $pathParamater[$i]. '/';
            }
        }

        return $parentContentPath;
    }
}
