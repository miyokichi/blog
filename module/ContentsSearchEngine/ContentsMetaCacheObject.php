<?php

namespace module\ContentsSearchEngine;

class ContentsMetaCacheObject
{
    protected $cache = array();
    
    /**
     * キャッシュをファイルに書き出し。
     */
    public function ExportCacheFile($cacheFilePath)
    {
        $json = \json_encode($this->cache);
        \file_put_contents($cacheFilePath, $json);
    }

    /**
     * ファイルからキャッシュをobjectにセット
     */
    public function SetCacheFile($cacheFilePath)
    {
        $this->cache = \json_decode(\file_get_contents($cacheFilePath), true);
    }

    /**
     * このobjectのキャッシュを取得
     */
    public function GetCache()
    {
        return $this->cache;
    }

    /**
     * コンテンツのキャッシュを生成。
     */
    public function GenerateCache($currentContentPath)
    {
        $currentContent = new \module\Content\Content($currentContentPath);
        $currentContent->MetaPurse();
        $childContentPaths = $currentContent->GetChildContentPaths();

        $this->cache[$currentContentPath]=
            [
                'contentPath' => $currentContentPath,
                'title' => $currentContent->title,
                'createAt' => $currentContent->createdAt,
                'updateAt' => $currentContent->updatedAt,
                'tags' => $currentContent->tags,
                'abstract'=> $currentContent->abstract,
                'childContentPaths' => $childContentPaths
            ];
        
        if(!empty($childContentPaths)){
            foreach ($childContentPaths as $childContentPath) {
                $this->Cache($childContentPath);
            }
        }
    }


}