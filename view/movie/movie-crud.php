<?php
namespace Anax\View;

if (!$resultset) {
    return;
}

?>
<!-- <p><?= $testVar?></p> -->

<h2>Uppdatera filmlistan</h2>

<table>
    <tr class="first">
        <th>Rad</th>
        <th>Id</th>
        <th>Bild</th>
        <th>Titel</th>
        <th>År</th>
    </tr>
    <?php $id = -1; foreach ($newRes as $row) :
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

<?php if ($showAll) : ?>
    <table>
        <tr class="first">
            <th>Rad</th>
            <th>Id</th>
            <th>Bild</th>
            <th>Titel</th>
            <th>År</th>
        </tr>
        <?php $id = -1; foreach ($showAll as $row) :
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



<form method="post">
    <fieldset>
    <legend>Select Movie</legend>

    <p>
        <label>Movie:<br>
        <select name="movieId">
            <option value="">Select a movie...</option>
            <?php foreach ($newRes as $movie) : ?>
            <option value="<?= $movie->id ?>"><?= $movie->title ?></option>
            <?php endforeach; ?>
        </select>
    </label>
    </p>
    

    <p>
        <input type="submit" name="doAdd" value="Add">
        <input type="submit" name="doEdit" value="Edit">
        <input type="submit" name="doDelete" value="Delete">
    </p>
    <!-- <p><input type="submit" name="showAll" value="show all"></p> -->
    </fieldset>
</form>



<!-- <form method="post">
    <fieldset>
    <legend>Select Movie</legend>

    <p>
        <label>Movie:<br>
        <select name="movieselect">
            <option value="">Select movie...</option>
            <?php foreach ($resultset as $movie) : ?>
            <option value="<?= $movie->id ?>"><?= $movie->title ?></option>
            <?php endforeach; ?>
        </select>
    </label>
    </p>
    <input type="hidden" name="editmovieId" value="<?= $movieId ?>"/>

    <p>
        <input type="submit" name="doEdit" value="Edit">
    </p>

    </fieldset>
</form> -->


    <!-- <form method="post">
        <fieldset>
        <legend>edit Movie</legend>
            <input type="hidden" name="movieId" value="<?= $movieId ?>"/>

            <p>
                <label>Title:<br> 
                <input type="text" name="movieTitle" value="<?= $movieTitle ?>"/>
                </label>
            </p>
            <p>
                <label>Year:<br> 
                <input type="number" name="movieYear" value="<?= $movieYear ?>"/>
            </p>
            <p>
                <label>Image:<br> 
                <input type="text" name="movieImage" value="<?= $movieImage ?>"/>
                </label>
            </p>
            
            <p>
                <input type="submit" name="doSave" value="Save">
            </p>
        </fieldset>
    </form> -->