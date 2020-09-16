<?php

namespace Anax\View;

// use Ylvan\Text\MyTextFilter;

if (!$resultset) {
    return;
}

// $textfilter = new MyTextFilter();
// $t4 = $textfilter->parse($alltext, $filters);

?>

<h1>here is all pages</h1>

<table>
    <tr class="first">
        <th>Id</th>
        <th>Title</th>
        <th>Type</th>
        <!-- <th>Status</th> -->
        <th>Published</th>
        <th>Deleted</th>
    </tr>
<?php $id = -1; foreach ($resultset as $row) :
    $id++; ?>
    <!-- <a href=""></a> -->
    <tr>
        <td><?= $row->id ?></td>
        <td>
            <!-- <a href="?route=<?= $row->path ?>"><?= $row->title ?></a> -->
            <form action="post">
                <button type="submit" name="doView" class="textbutton" value="<?= $row->id ?>"><?= $row->title ?></button>
            </form>
        </td>
        <td><?= $row->type ?></td>
        <!-- <td><?= $row->status ?></td> -->
        <td><?= $row->published ?></td>
        <td><?= $row->deleted ?></td>
    </tr>
<?php endforeach; ?>
</table>