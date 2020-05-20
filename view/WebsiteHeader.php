<?php

namespace view;

class WebsiteHeader
{
    public static function output()
    {
        //ルート直下のコンテンツを取得
        $rootContent = new \module\Content\Content(\Setting::ROOT_CONTENT_PATH);
        $headerListContentPaths = $rootContent->GetChildContentPaths();
        $headerListContents = array();
        foreach ($headerListContentPaths as $headerListContentPath) {
            $headerListContents[$headerListContentPath] = new \module\Content\Content($headerListContentPath);
            $headerListContents[$headerListContentPath]->MetaPurse();
        }
        //var_dump($headerListContents);
        ?>
        <header class="header">
            <div class="header_website-name">
                <a href="/">
                    <?=\Setting::WEBSITE_NAME?>
                </a>
            </div>
            <nav class="header_nav">
                <ul class="header_nav-list">
                    <?php
                    foreach ($headerListContents as $headerListContentPath => $headerListContent) {
                        echo '<li class="header_nav-list_item">';
                        echo '<a href="' . $headerListContent->GetAccessPath() . '">';
                        echo $headerListContent->title;
                        echo '</a>';
                        echo '</li>';
                    }
                    ?>
                </ul>
            </nav>

        </header>
        <?php
    }
}
