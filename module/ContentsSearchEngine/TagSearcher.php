<?php

namespace module\ContentsSearchEngine;

class TagSearcher
{
    protected $tagIndexFilePath;
    protected $tagIndex;

    public function __construct($tagIndexFilePath)
    {
        $this->tagIndexFilePath = $tagIndexFilePath;
        $this->tagIndex = \json_decode(\file_get_contents($tagIndexFilePath), true);
    }

    /**
     * tag名でコンテンツを検索
     * @return array 検索結果のコンテンツパスの配列
     */
    public function search($searchingTagName)
    {
        $result = array();
        $contentsMetaCacheObject = new \module\ContentsSearchEngine\ContentsMetaCacheObject();
        $contentsMetaCacheObject->SetCacheFile(\Setting::CONTENT_META_CACHE_FILE_PATH);
        $contentsMetaCache = $contentsMetaCacheObject->GetCache();
        
        foreach ($this->tagIndex as $tagName => $matchedContentPaths) {
            if ($tagName == $searchingTagName) {
                foreach ($matchedContentPaths as $matchedContentPath) {
                    $result[] = $contentsMetaCache[$matchedContentPath];
                }
            }
        }
        return $result;
    }
}
