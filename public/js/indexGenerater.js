class IndexGenerator {

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

    headerElementCount;


    constructor(indexGenerateFrom, indexGenerateTo){
        this.indexGenerateFrom = indexGenerateFrom;
        this.indexGenerateTo = indexGenerateTo;

        this.headerElements= this.indexGenerateFrom.querySelectorAll(this.headerSelector);
    }

    GetIndexIndentLevel(headerTagName) {
        var indentLevel = 0;
        switch (headerTagName) {
            case "h0":
                indentLevel = 0;
                break;

            case "h1":
                indentLevel = 1;
                break;

            case "h2":
                indentLevel = 2;
                break;

            case "h3":
                indentLevel = 3;
                break;

            case "h4":
                indentLevel = 4;
                break;

            case "h5":
                indentLevel = 5;
                break;

            case "h6":
                indentLevel = 6;
                break;

            default:
                indentLevel = false;
                break;
        }
        return indentLevel;
    }

    GenerateIndex(){
        this.headerElementCount = 0;
        var indexList = this.GenerateIndexList(0);
        this.indexGenerateTo.appendChild(indexList);
    }

    GenerateIndexList(indentLevel) {
        var unorderList = document.createElement("ul");
        indentLevel += 1;

        while (this.headerElementCount < this.headerElements.length) {
            var currentElement = this.headerElements[this.headerElementCount];

            //インデントそのままの時
            if (this.GetIndexIndentLevel(currentElement.tagName.toLowerCase()) == indentLevel) {
                var unorderListItem = document.createElement("li");

                //リンク用のidをheader要素につける
                currentElement.id = currentElement.textContent;
                //リンク用aタグ
                var anchor = document.createElement("a");
                anchor.textContent = currentElement.textContent;
                anchor.setAttribute("href", "#" + anchor.textContent);

                unorderListItem.appendChild(anchor);
                unorderList.appendChild(unorderListItem);
                this.headerElementCount++;
            }
            //インデントが下がったとき
            else if (this.GetIndexIndentLevel(currentElement.tagName.toLowerCase()) > indentLevel) {
                //ulを追加
                var newUnorderList = this.GenerateIndexList(indentLevel);
                unorderList.appendChild(newUnorderList);
            }
            //インデントが上がったとき
            else {
                break;
            }

        }

        return unorderList;
    }

};



document.addEventListener("DOMContentLoaded", function () {
    var indexFrom = document.getElementById("js-content_main_article");
    var indexTo = document.getElementById("js-content_index_box");

    var indexGenerater = new IndexGenerator(indexFrom, indexTo);
    indexGenerater.GenerateIndex();
});