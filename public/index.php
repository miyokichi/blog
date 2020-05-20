<?php
require_once $_SERVER['DOCUMENT_ROOT'] . '/../vendor/autoload.php';
require_once $_SERVER['DOCUMENT_ROOT'] .'/../setting.php';
require_once $_SERVER['DOCUMENT_ROOT'] .'/../module/autoload.php';
require_once $_SERVER['DOCUMENT_ROOT'] .'/../view/autoload.php';
require_once $_SERVER['DOCUMENT_ROOT'] .'/../controller/autoload.php';


//アクセスurlの解析
if (array_key_exists('pathname', $_GET)) {
    $pathname = $_GET['pathname'];
} else {
    $pathname = '';
}
//echo $pathname;


//タグでの検索の場合-----------------------------------------------------------------------------------
if ($pathname === 'search/') {
    controller\TagSearchPageController::Show($_GET['tag_name']);
    exit;
}

//インデックスを行う場合--------------------------------------------------------------------------------
if($pathname === 'index/'){
    controller\IndexResultPageController::Show();
    exit;
}


//ルート以外のコンテンツの場合----------------------------------------------------------------------------
elseif ($pathname != '') {
    $contentPath = 'contents/root/' . $pathname;

    if (!file_exists($contentPath)) {
        //404 not found
        header("HTTP/1.0 404 Not Found");
        print(file_get_contents("/404.html"));
        exit;
    }

    controller\ContentPageController::Show($contentPath);
    exit;
}

//ルートコンテンツ(top page)の場合---------------------------------------------------------------------------

else {
    $content = new module\Content\Content('contents/root/');
    $content->Parse();

    $parentContents = array();
    $parentContentPath = $content->GetParentContentPath();
    while ($parentContentPath) {
        $parentContent = new \module\Content\Content($parentContentPath);
        $parentContent->MetaPurse();
        \array_unshift($parentContents, $parentContent);
    }
    
    $previewContentPath = $content->GetPreviewContentPath();
    if ($previewContentPath) {
        $previewContent = new \module\Content\Content($previewContentPath);
        $previewContent->MetaPurse();
    }

    $nextContentPath = $content->GetNextContentPath();
    if ($nextContentPath) {
        $nextContent = new \module\Content\Content($nextContentPath);
        $nextContent->MetaPurse();
    }
        
    $childContentPaths = $content->GetChildContentPaths();
    $childContents = array();
    foreach ($childContentPaths as $childContentPath) {
        $childContents[$childContentPath] = new \module\Content\Content($childContentPath);
        $childContents[$childContentPath]->MetaPurse();
    } ?>





<!--- htmlの出力(top page) --------------------------------------------------------------------------------------------->
<html>

<?=\view\Head::output($content->title.' | '.\Setting::WEBSITE_NAME, $content->abstract)?>

<body>
    <?=\view\WebsiteHeader::output()?>

    <div class="content">
        <header class="content_header">

            <div class="content_header_breadcrumbs">
                <ol class="content_header_breadcrumbs_list">
                    <?php foreach ($parentContents as $parentContent) { ?>
                    <li class="content_header_breadcrumbs_list_item">
                        <a
                            href="<?=$parentContent->getAccessPath()?>">
                            <?=$parentContent->title?>
                        </a>
                    </li>
                    <?php } ?>
                </ol>
            </div>

            <div class='content_header_title'>
                <?=$content->title?>
            </div>

            <div class="content_header_time">
                <span class="content_header_time_create-at">
                    作成：<?=$content->createdAt?>
                </span>
                <span class="content_header_time_update-at">
                    更新：<?=$content->updatedAt?>
                </span>
            </div>

            <ul class="content_header_tag-list">
                tag:
                <?php
                        foreach ($content->tags as $tag) {
                            echo '<li class="content_header_tag-list_item">';
                            echo '<a href="/search/?tag_name=' . $tag . '">';
                            echo $tag;
                            echo '</a></li>';
                        } ?>
            </ul>

            <div class="content_header_abstract">
                <p>
                    <?=$content->abstract?>
                </p>
            </div>
        </header>

        <div class="content_index" id="js-content_index">
            <p>目次</p>
        </div>

        <main class="content_main">
            <article class="content_main_article">
                <?=$content->htmlContent?>
            </article>

            <div class="content_main_child-contents">
                <?php
                if (!empty($childContentPaths)) {
                    //echo '<div class="content_main_child-contents_headline">このカテゴリーのコンテンツ</div>';

                    echo '<dl class="content_main_child-contents_list">';
                    foreach ($childContents as $childContentPath => $childContent) {
                        echo '<article class="content_main_child-contents_list_item">';
                        echo '<dt>';
                        echo '<a href="'. $childContent->GetAccessPath() . '">';
                        echo $childContent->title;
                        echo '</a>';
                        echo '</dt>';
                        echo '<dd>';
                        echo $childContent->abstract;
                        echo '</dd>';
                        echo '</article>';
                    }
                    echo '</dl>';
                } ?>
            </div>
        </main>

        <footer class="content_footer">

            <div class="content_footer_brother">
                <?php if ($previewContentPath) { ?>
                <a class="content_footer_brother_prev"
                    href="<?=$previewContent->getAccessPath()?>">
                    <p class="content_footer_brother_prev_label">PREVIOUS</p>
                    <p>
                        <?=$previewContent->title?>
                    </p>
                </a>
                <?php } ?>

                <?php if ($nextContentPath) { ?>
                <a class="content_footer_brother_next"
                    href="<?=$nextContent->getAccessPath()?>">
                    <p class="content_footer_brother_next_label">NEXT</p>
                    <p>
                        <?=$nextContent->title?>
                    </p>
                </a>
                <?php } ?>
            </div>


            <div class="content_footer_meta">

                <div class="content_footer_meta_breadcrumbs">

                    <?php if (!empty($parentContents)) { ?>
                    <ol class="content_footer_meta_breadcrumbs_list">
                        カテゴリー:
                        <?php foreach ($parentContents as $parentContent) { ?>
                        <li class="content_footer_meta_breadcrumbs_list_item">
                            <a
                                href="<?=$parentContent->getAccessPath()?>">
                                <?=$parentContent->title?>
                            </a>
                        </li>
                        <?php } ?>
                    </ol>
                    <?php } ?>
                </div>

                <div class="content_footer_meta_time">
                    <span class="content_footer_meta_create-at">
                        作成：<?=$content->createdAt?>
                    </span>
                    <span class="content_footer_meta_update-at">
                        更新：<?=$content->updatedAt?>
                    </span>
                </div>

                <ul class="content_footer_meta_tag-list">
                    tag:
                    <?php
                        foreach ($content->tags as $tag) {
                            echo '<li class="content_footer_meta_tag-list_item">';
                            echo '<a href="/search/?tag_name=' . $tag . '">';
                            echo $tag;
                            echo '</a></li>';
                        } ?>
                </ul>

            </div>
        </footer>

    </div>



    <?=\view\WebsiteFooter::output()?>

</body>


</html>

<?php
}
