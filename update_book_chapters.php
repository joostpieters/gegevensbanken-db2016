<?php
	
require_once("gb/controller/BookController.php");
require_once("gb/controller/ChapterController.php");
$bookController = new gb\controller\BookController();
$bookController->process();

$chapterController = new gb\controller\ChapterController();
$chapterController->process();
$chapters = $chapterController->getSearchResult();

$title = "book_uri =" . $bookController->getSelectedBookUri();
require("template/top.tpl.php");
?>    
<form method="post">
<table style="width: 100%">

<tr>
    <td colspan="2">
    <table style="width: 100%">        
        <tr>
            <td>Chapter</td>            
            <td style="width: 85%">
                <select style="width: 50%" name="chapter" onchange="this.form.submit()">
                    <option value="not set">--------Chapter ---------- </option>
                    <?php
                    foreach($chapters as $chapter) {
                        $select = "";
                        if (isset($_POST["chapter"]) and $_POST["chapter"] == $chapter->getChapterNumber()){
                            $select = " selected ";
                        }
                        echo "<option value=\"", $chapter->getChapterNumber(), "\"", $select, ">", $chapter->getChapterNumber(), "</option>" ;
                    }

                    ?>
                </select>"
            </td>          
        </tr>
        <tr>
            <td>Old text:</td>
            <td><textarea name="old_text" cols="60" rows="6"><?php
                        if(isset($_POST["chapter"]) and $_POST["chapter"] != "not set"){
                            echo $chapterController->getTextFromChapter($_POST["chapter"]);
                        }
                        else{
                            echo "Please select a chapter.";
                        }
                    ?>
                </textarea></td>
        </tr>
        <tr>
            <td>New text:</td>
            <td><textarea name="new_text" cols="60" rows="6"></textarea></td>
        </tr>
        <tr>
            <td >&nbsp;</td>            
            <td><input type ="submit" name="update" value="Update" ></td>
        </tr>
    </table>
    </td>
</table>
</form>



<?php
	require("template/bottom.tpl.php");
?>