<?php
namespace Anax\View;

if (!$resultset) {
    return;
}

?>

<h2>Lägg till en film</h2>

<p> <?= $testVar?></p>


<?php if ($movielist) : ?>
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
<?php endif; ?>
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
    <legend>Add movie</legend>
    <!-- <input type="hidden" name="movieId" value="movieId"/> -->

    <p>
        <label>Title:<br> 
        <input type="text" name="movieTitle" value="A title"/>
        </label>
    </p>

    <p>
        <label>Year:<br> 
        <input type="number" name="movieYear" value="2017"/>
    </p>

    <p>
        <label>Image:<br> 
        <input type="text" name="movieImage" value="img/noimage.png"/>
        </label>
    </p>

    <p>
        <input type="submit" name="doAdd" value="Save">
    </p>

    </fieldset>
</form>
