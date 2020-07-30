<?php
namespace Anax\View;

if (!$resultset) {
    return;
}

?>
<h2>Sök film efter årtal</h2>



<?php if ($yearRes) : ?>
    <p>Resultat från: <?= $year1?> till: <?= $year2?></p>
    <table>
        <tr class="first">
            <th>Rad</th>
            <th>Id</th>
            <th>Bild</th>
            <th>Titel</th>
            <th>År</th>
        </tr>
        <?php $id = -1; foreach ($yearRes as $row) :
            $id++;
            ?>
        <tr>
            <td><?= $id ?></td>
            <td><?= $row->id ?></td>
            <td><img class="thumb" src="<?= $row->image ?>"></td>
            <td><?= $row->title ?></td>
            <td><?= $row->year ?></td>
        </tr>
        <?php endforeach; ?>
    </table>
<?php endif; ?>


<form method="get">
    <fieldset>
    <legend>Search</legend>
    <input type="hidden" name="route" value="search-year">
    <p>
        <label>Created between: 
        <input type="number" name="year1" value="year1" min="1900" max="2100"/>
        - 
        <input type="number" name="year2" value="year2" min="1900" max="2100"/>
        </label>
    </p>
    <p>
        <input type="submit" name="doSearch" value="Search">
    </p>
    </fieldset>
</form>


