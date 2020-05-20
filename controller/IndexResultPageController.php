<?php

namespace controller;

class IndexResultPageController
{
    public static function Show()
    {
        $contentsMetaCacheObject = new \module\ContentsSearchEngine\ContentsMetaCacheObject;
        $contentsMetaCacheObject->GenerateCache();
        $contentsMetaCacheObject->ExportCacheFile(\Setting::CONTENT_META_CACHE_FILE_PATH);
        $tagIndexer = new \module\ContentsSearchEngine\TagIndexer();
        $tagIndexer->GenerateIndex(\Setting::CONTENT_META_CACHE_FILE_PATH);
        $tagIndexer->ExportIndexFile(\Setting::TAG_INDEX_FILE_PATH);?>

<!--- htmlの出力 --------------------------------------------------------------------------------------------->
<html>

<?=\view\Head::output('インデックスを行いました。 | '.\Setting::WEBSITE_NAME, 'インデックスを行いました。')?>

<body>
    <?=\view\WebsiteHeader::output()?>

    <div class="content">

        <header class="content_header">
            <div class='content_header_title'>
                インデックス結果
            </div>
        </header>

        <main class="content_main">
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