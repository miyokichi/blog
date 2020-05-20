<?php

namespace module\ContentsSearchEngine;

require_once __DIR__ . '/ContentsMetaCacheObject.php';

class TagIndexer
{
    protected $index;

    /**
     * インデックスをファイルに書き出し。
     */
    public function ExportIndexFile($indexFilePath)
    {
        $json = \json_encode($this->index);
        \file_put_contents($indexFilePath, $json);
    }

    /**
     * インデックスを取得。
     */
    public function GetIndex()
    {
        return $this->index;
    }

    /**
     * インデックスを生成。
     */
    public function GenerateIndex($contentsMetaCacheFilePath)
    {
        $contentsMetaCacheObject = new ContentsMetaCacheObject();
        $contentsMetaCacheObject->SetCacheFile($contentsMetaCacheFilePath);
        $this->GenerateIndexFromContentsMetaCache($contentsMetaCacheObject->GetCache());
    }

    /**
     * ContentsMetaCacheからtagの転置インデックスを生成
     */
    protected function GenerateIndexFromContentsMetaCache($contentsMetaCache)
    {
        $this->index = array();
        foreach($contentsMetaCache as $contentPath => $contentMeta){
            foreach($contentMeta['tags'] as $tagName){
                $this->index[$tagName][] = $contentPath;
            }
        }
    }
}