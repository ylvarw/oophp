<?php
namespace Anax\View;

if (!$resultset) {
    return;
}

?>

<h2>Ta bort en film</h2>

<table>
    <tr class="first">
        <!-- <th>Rad</th> -->
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
        <!-- <td><?= $row->id ?></td> -->
        <td><img class="thumb" src="<?= $row->image ?>"></td>
        <td><?= $row->title ?></td>
        <td><?= $row->year ?></td>
    </tr>
    <?php endforeach; ?>
</table>

    <form method="post">
        <fieldset>
        <h3>
        <legend>Delete Movie</legend>
        </h3>
            <!-- <input type="hidden" name="movieId" value="<?= $movieId ?>"/> -->

            <p>
                <label>Movie id:<br> 
                <input type="number" name="movieId" required/>
                </label>
            </p>
            <!-- <p>
                <label>New Title:<br> 
                <input type="text" name="movieTitle"/>
                </label>
            </p>
            <p>
                <label>New Year:<br> 
                <input type="number" name="movieYear"/>
            </p>
            <p>
                <label>New Image:<br> 
                <input type="text" name="movieImage"/>
                </label>
            </p> -->
            
            <p>
                <input type="submit" name="doDelete" value="Delete">
            </p>
        </fieldset>
    </form>

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

<!-- <form method="post">
    <fieldset>
    <legend>Delete Movie</legend>

    <p>
        <label>Movie:<br>
        <select name="movieId">
            <option value="">Select movie...</option>
            <?php foreach ($resultset as $movie) : ?>
                <option value="<?= $id ?>"><?= $movie->title ?></option>
            <?php endforeach; ?>
        </select>
    </label>
    </p>

    <p>
        <input type="submit" name="doDelete" value="Delete">
    </p>
    </fieldset>
</form> -->
