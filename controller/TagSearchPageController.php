<?php

namespace controller;

class TagSearchPageController
{
    public static function Show($searchingTagName)
    {
        //検索を行うときはキャッシュを利用する
        $tagSearcher = new \module\ContentsSearchEngine\TagSearcher(\Setting::TAG_INDEX_FILE_PATH);
        $matchedContents = $tagSearcher->search($searchingTagName); ?>

<!--- htmlの出力 --------------------------------------------------------------------------------------------->
<html>

<?=\view\Head::output('Tag:' . $searchingTagName . 'の検索結果 | '.\Setting::WEBSITE_NAME, 'Tag:' . $searchingTagName . 'での検索結果です。')?>

<body>
    <?=\view\WebsiteHeader::output()?>

    <div class="content">

        <header class="content_header">
            <div class='content_header_title'>
                Tag:"<?=$searchingTagName?>"の検索結果
            </div>
        </header>

        <!--    
        <div class="content_index" id="js-content_index">
            <p>目次</p>
        </div>
        --->

        <main class="content_main">

            <div class="content_main_child-contents">
                <?php
                    echo '<dl class="content_main_child-contents_list">';
                    foreach ($matchedContents as $matchedContentPath => $matchedContent) {
                        echo '<article class="content_main_child-contents_list_item">';
                        echo '<dt>';
                        echo '<a href="'. $matchedContent['accessPath'] . '">';
                        echo $matchedContent['title'];
                        echo '</a>';
                        echo '</dt>';
                        echo '<dd>';
                        echo $matchedContent['abstract'];
                        echo '</dd>';
                        echo '</article>';
                    }
                    echo '</dl>';
                 ?>
            </div>
        </main>

        <footer class="content_footer">
            <div class="content_footer_meta">
            </div>
        </footer>

    </div>



    <?=\view\WebsiteFooter::output()?>

</body>


</html>

<?php
    }
}
