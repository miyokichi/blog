<?php

namespace module\Content;

class MarkdownObject
{
    public $markdownPath;
    public $title;
    public $createdAt;
    public $updatedAt;
    public $tags = array();
    public $abstract;
    public $htmlContent;
    public $markdown;

    protected $rowNumber;
    protected $rowCount;
    protected $lines;

    //マッチング用正規表現
    protected $titleRegexp;
    protected $createdAtRegexp;
    protected $updatedAtRegexp;
    protected $tagRegexp;
    protected $abstractRegexp;


    
    public function __construct($markdownPath)
    {
        $this->markdownPath = $markdownPath;
    }

    protected function Initialize()
    {
        $rawContent = @file_get_contents($this->markdownPath);
        if ($rawContent === false) {
            $rawContent = 'コンテンツがありません';
        }
        $this->lines = explode("\n", $rawContent);
        $this->rowNumber = count($this->lines);
        $this->rowCount = 0;

        $this->title = '';
        $this->createdAt = '';
        $this->updatedAt = '';
        $this->tags = array();
        $this->html = '';
        $this->markdown = '';
        $this->abstract ='';

        $this->titleRegexp ='/^title:(.*)/';
        $this->createdAtRegexp = '/^created_at:(.*)/';
        $this->updatedAtRegexp = '/^updated_at:(.*)/';
        $this->tagRegexp = '/^tag:(.*)/';
        $this->abstractRegexp = '/^abstract:(.*)/';
    }

    public function MetaPurse()
    {
        $this->Initialize();
        
        while ($this->rowCount < $this->rowNumber) {
            //title
            if (preg_match($this->titleRegexp, $this->lines[$this->rowCount], $matches)) {
                //var_dump('fdsafdsafdsafgfdasgfdasfdsadf');
                $this->title = $matches[1];
            }
            //created at
            elseif (preg_match($this->createdAtRegexp, $this->lines[$this->rowCount], $matches)) {
                $this->createdAt = $matches[1];
            }
            //updated at
            elseif (preg_match($this->updatedAtRegexp, $this->lines[$this->rowCount], $matches)) {
                $this->updatedAt = $matches[1];
            }
            //tag
            elseif (preg_match($this->tagRegexp, $this->lines[$this->rowCount], $matches)) {
                $this->tags = explode(' ', $matches[1]);
            }
            //abstract
            elseif (preg_match($this->abstractRegexp, $this->lines[$this->rowCount], $matches)) {
                $this->abstract = $matches[1];
            }
            //end content-meta 
            else {
                break;
            }

            $this->rowCount++;
        }
    }

    public function Parse()
    {
        $this->MetaPurse();

        while ($this->rowCount < $this->rowNumber) {
            $this->markdown .= $this->lines[$this->rowCount] . "\n";
            $this->rowCount++;
        }
        $parser = new \cebe\markdown\MarkdownExtra();
        $parser->html5 = true;
        $this->htmlContent = $parser->parse($this->markdown);
    }
}
