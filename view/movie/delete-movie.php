<?php
namespace Anax\View;

if (!$resultset) {
    return;
}

?>

<h2>Ta bort en film</h2>

<!-- <p> <?= $testVar?></p> -->
<!-- IF $doDelete VISA TABELL -->
<!-- <table>
    <tr class="first">
        <th>Rad</th>
        <th>Id</th>
        <th>Bild</th>
        <th>Titel</th>
        <th>År</th>
    </tr>
    <?php $id = -1; foreach ($resultset as $row) :
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
</table> -->

<form method="post">
    <fieldset>
    <legend>Delete Movie</legend>

    <p>
        <label>Movie:<br>
        <select name="movieId">
            <option value="">Select movie...</option>
            <?php foreach ($resultset as $movie) : ?>
            <option value="<?= $movie->id ?>"><?= $movie->title ?></option>
            <?php endforeach; ?>
        </select>
    </label>
    </p>

    <p>
        <input type="submit" name="doDelete" value="Delete">
    </p>
    </fieldset>
</form>
