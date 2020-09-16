<?php
namespace Anax\View;

if (!$resultset) {
    return;
}

?>

<h2>Redigera en film</h2>

<table>
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
</table>

    <form method="post">
        <fieldset>
        <legend>edit Movie</legend>
            <!-- <input type="hidden" name="movieId" value="<?= $movieId ?>"/> -->

            <p>
                <label>Movie id:<br> 
                <input type="id" name="movieId" required/>
                </label>
            </p>
            <p>
                <label>Title:<br> 
                <input type="text" name="movieTitle"/>
                </label>
            </p>
            <p>
                <label>Year:<br> 
                <input type="number" name="movieYear"/>
            </p>
            <p>
                <label>Image:<br> 
                <input type="text" name="movieImage"/>
                </label>
            </p>
            
            <p>
                <input type="submit" name="doEdit" value="Save">
            </p>
        </fieldset>
    </form>




