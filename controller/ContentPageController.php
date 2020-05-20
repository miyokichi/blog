<?php

namespace controller;

class ContentPageController
{
    public static function Show($contentPath)
    {
        $content = new \module\Content\Content($contentPath);
        $content->Parse();

        $parentContents = array();
        $parentContentPath = $content->GetParentContentPath();
        while ($parentContentPath) {
            $parentContent = new \module\Content\Content($parentContentPath);
            $parentContent->MetaPurse();
            \array_unshift($parentContents, $parentContent);
            $parentContentPath = $parentContent->GetParentContentPath();
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

<!--- htmlの出力 --------------------------------------------------------------------------------------------->
<html>

<?=\view\Head::output($content->title.' | '.\Setting::$websiteName, $content->abstract)?>

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
}
