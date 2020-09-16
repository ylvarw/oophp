<?php
namespace Anax\View;

if (!$resultset) {
    return;
}

?>


<h2>Sök film efter titel</h2>


<?php if ($titleRes) : ?>
    <h3>Alla resultat för: <?= $searchTitle ?></h3>
    <table>
        <tr class="first">
            <th>Rad</th>
            <th>Id</th>
            <th>Bild</th>
            <th>Titel</th>
            <th>År</th>
        </tr>
        <?php $id = -1; foreach ($titleRes as $row) :
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
        <label>Title (use % as wildcard): 
        <input type="text" name="searchTitle"/>
        </label>
    </p>
    <p>
        <input type="submit" name="doSearch" value="Search">
    </p>
    </fieldset>
</form>