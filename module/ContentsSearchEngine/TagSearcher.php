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

    public function search($searchingTagName)
    {
        $result = array();
        foreach ($this->tagIndex as $tagName => $contentPath) {
            if($tagName == $searchingTagName){
                $result[] = $contentPath;
            }
        }
        return $result;
    }
}