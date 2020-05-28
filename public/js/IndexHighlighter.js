class IndexHighlighter {
    headerSelector = "h1,h2,h3,h4,h5,h6";
    /**
     * indexを作成する場所の要素
     * @type {Element}
     */
    indexGenerateTo;
    /**
     * indexを作成したい要素を含む親要素
     */
    indexGenerateFrom;
    /**
     * indexを作成したい見出し要素
     */
    headerElements;
    /**
     * highlightしている目次の要素
     */
    highlightIndexItem;

    Initialize(indexGenerateFrom, indexGenerateTo) {
        this.indexGenerateFrom = indexGenerateFrom;
        this.indexGenerateTo = indexGenerateTo;
        this.headerElements = this.indexGenerateFrom.querySelectorAll(this.headerSelector);
    }

    HighlightOnLoad() {
        //画面上一番上の見出し要素を取得
        var screenTop = window.scrollY;
        var screenBottom = window.scrollY + document.documentElement.clientHeight;

        var highlightHeaderElement = null;
        for (const headerElement of this.headerElements) {
            if ((screenTop < headerElement.getBoundingClientRect().top) && (headerElement.getBoundingClientRect().top < screenBottom)) {
                highlightHeaderElement = headerElement;
                break;
            }
        }


        //見出し要素のidと同じhrefの#を持つanchor要素検索
        var indexAnchorElements = this.indexGenerateTo.querySelectorAll("a");
        if (highlightHeaderElement) {
            for (const indexAnchorElement of indexAnchorElements) {
                if (indexAnchorElement.hash == encodeURI("#" + highlightHeaderElement.id)) {
                    //__highlightクラスを取り除く
                    this.highlightIndexItem = indexAnchorElement;
                    //上記の要素にhighlightクラスをつける
                    this.highlightIndexItem.classList.add("__highlight");
                }
            }
        }
    }

    HighlightOnScroll() {
        //画面上一番上の見出し要素を取得
        var screenTop = window.scrollY;
        var screenBottom = window.scrollY + document.documentElement.clientHeight;

        var highlightHeaderElement = null;
        for (const headerElement of this.headerElements) {
            if ((screenTop < headerElement.getBoundingClientRect().top) && (headerElement.getBoundingClientRect().top < screenBottom)) {
                highlightHeaderElement = headerElement;
                break;
            }
        }


        //見出し要素のidと同じhrefの#を持つanchor要素検索
        var indexAnchorElements = this.indexGenerateTo.querySelectorAll("a");
        if (highlightHeaderElement) {
            for (const indexAnchorElement of indexAnchorElements) {
                if (indexAnchorElement.hash == encodeURI("#" + highlightHeaderElement.id)) {
                    //__highlightクラスを取り除く
                    this.highlightIndexItem.classList.remove("__highlight");
                    this.highlightIndexItem = indexAnchorElement;
                    //上記の要素にhighlightクラスをつける
                    this.highlightIndexItem.classList.add("__highlight");
                }
            }
        }
    }
}




var indexHighlighter = new IndexHighlighter();


document.addEventListener("DOMContentLoaded", function () {
    var indexFrom = document.getElementById("js-content_main_article");
    var indexTo = document.getElementById("js-content_index_box");
    indexHighlighter.Initialize(indexFrom, indexTo);

    indexHighlighter.HighlightOnLoad();
});

document.addEventListener("scroll", function () {
    indexHighlighter.HighlightOnScroll();
});