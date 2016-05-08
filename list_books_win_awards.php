<?php
	
$title = "Books that win awards";

require("template/top.tpl.php");
require_once("gb/controller/WinAwardController.php");

$winAwardController = new gb\controller\WinAwardController();
$winAwardController->process();
?>    
<form method="post">
<table style="width: 100%">

<tr>
    <td colspan="4">
    <table style="width: 100%">        
     
         <tr>
            <td>From time</td>
            <td><input type="text" name ="from_time" value="<?php if (isset($_POST["from_time"])) echo $_POST["from_time"]; else echo "0000-0-0" ?>"   ></td>
            <td>To time</td>
            <td><input type="text" name ="to_time" value="<?php if (isset($_POST["to_time"])) echo $_POST["to_time"]; else echo "3000-0-0" ?>"></td>            
        </tr>
        <tr>
            <td >&nbsp;</td>            
            <td><input type ="submit" name="search" value="Search" ></td>
            <td >&nbsp;</td>
            <td >&nbsp;</td>
    
        </tr>
    </table>
    </td>
</table>
</form>


<table style="width: 100%">
    <tr>
        <td></td>
        <td>Total number of books</td>
    </tr>
    <?php
    $result = $winAwardController->getResult();
    foreach($result as $country => $countryResult){
        echo "<tr><td><br /><b>".$country."<br />_____________________</b></td><td></td></tr>";
        foreach($countryResult as $item){
            echo "<tr><td>".$item[0]."</td><td>".$item[1]."</td></tr>";
        }
    }
    ?>
</table>

<?php
	require("template/bottom.tpl.php");
?>