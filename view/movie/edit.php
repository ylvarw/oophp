<?php
namespace Anax\View;

if (!$resultset) {
    return;
}

?>

<h2>Redigera en film</h2>

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
        <legend>Edit Movie</legend>
        </h3>
            <!-- <input type="hidden" name="movieId" value="<?= $movieId ?>"/> -->

            <p>
                <label>Movie id:<br> 
                <input type="number" name="movieId" required/>
                </label>
            </p>
            <p>
                <label>New Title:<br> 
                <input type="text" name="movieTitle" required/>
                </label>
            </p>
            <p>
                <label>New Year:<br> 
                <input type="number" name="movieYear" required/>
            </p>
            <p>
                <label>New Image:<br> 
                <input type="text" name="movieImage" placeholder= "img/noimage.png" requireds/>
                </label>
            </p>
            
            <p>
                <input type="submit" name="doEdit" value="Save">
            </p>
        </fieldset>
    </form>




