<?php
	
$title = "Writers whose spouses are writers";

require("template/top.tpl.php");
require_once("gb/controller/SearchCoupleController.php");
require_once("gb/controller/SearchWritersController.php");
require_once("gb/domain/Couple.php");

$searchCoupleController = new gb\controller\SearchCoupleController();
$searchWriterController = new gb\controller\SearchWritersController();

$couples = $searchCoupleController->findWritersWhoseSpouseAlsoWrites();
?>    
<form method="post">
<table style="width: 100%">

<tr>
        <td>Writer</td>
        <td>Spouse</td>
        <td>From time</td>  
        <td>To time </td>
    </tr>
    <?php
    foreach($couples as $couple) {
        ?>
        <tr>
            <td><?php echo $searchWriterController->getWriterByUri($couple->getPerson())[0]->getFullName(); ?></td>
            <td><?php echo $searchWriterController->getWriterByUri($couple->getSpouse())[0]->getFullName(); ?></td>
            <td><?php echo $couple->getFromTime(); ?></td>
            <td><?php echo $couple->getToTime(); ?></td>

        </tr>
        <?php
    }
    ?>
</table>
</form>

<?php
	require("template/bottom.tpl.php");
?>