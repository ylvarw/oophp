<?php
namespace Anax\View;

if (!$resultset) {
    return;
}
?>


<?php if ($deleteRes) : ?>
    <h3>ta bort <?$deleteRes->title?>?</h3>
    <form method="post">
    <button type="submit" name="doDelete" value="<?= $deleteRes->id ?>">Delete</button>
    </form>
<?php endif; ?>

<?php if ($editRes) : ?>
    <form method="post">
        <fieldset>
        <legend>Edit content</legend>
        <input type="hidden" name="contentId" value="<?$editRes->id?>"/>

        <p>
            <label>Title:<br> 
            <input type="text" name="contentTitle" value="<?$editRes->title?>"/>
            </label>
        </p>

        <p>
            <label>Path:<br> 
            <input type="text" name="contentPath" value="<?$editRes->path?>"/>
        </p>

        <p>
            <label>Slug:<br> 
            <input type="text" name="contentSlug" value="<?$editRes->slug?>"/>
        </p>

        <p>
            <label>Text:<br> 
            <textarea name="contentData" value="<?$editRes->data?>"></textarea>
        </p>

        <p>
            <label>Type: (post/page)<br> 
            <input type="text" name="contentType" value="<?$editRes->type?>"/>
        </p>

        <p>
            <label>Filter:<br> 
            <input type="text" name="contentFilter" value="<?$editRes->filter?>"/>
        </p>

        <p>
            <label>Publish:<br> 
            <input type="datetime-local" name="contentPublish" value="<?$editRes->publish?>"/>
        </p>

        <p>
            <button type="submit" name="doSave"><i class="fa fa-floppy-o" aria-hidden="true"></i> Save</button>
            <!-- <button type="reset"><i class="fa fa-undo" aria-hidden="true"></i> Reset</button> -->
            <!-- <button type="submit" name="doDelete"><i class="fa fa-trash-o" aria-hidden="true"></i> Delete</button> -->
        </p>
        </fieldset>
    </form>
<?php endif; ?>

<?php if (!$editRes) : ?>
    <h1>Redigera inlägg</h1>
    <table>
        <tr class="first">
            <th>Id</th>
            <th>Title</th>
            <th>Type</th>
            <th>Published</th>
            <th>Created</th>
            <th>Updated</th>
            <th>Deleted</th>
            <th>Actions</th>
        </tr>
    <?php $id = -1; foreach ($resultset as $row) :
        $id++; ?>
        <tr>
            <td><?= $row->id ?></td>
            <td><?= $row->title ?></td>
            <td><?= $row->type ?></td>
            <td><?= $row->published ?></td>
            <td><?= $row->created ?></td>
            <td><?= $row->updated ?></td>
            <td><?= $row->deleted ?></td>
            <td>
                <form method="post">
                    <button type="submit" name="doEdit" value="<?= $row->id ?>">Edit</button>
                    <button type="submit" name="askDelete" value="<?= $row->id ?>">Delete</button>
                </form>
            </td>
        </tr>
    <?php endforeach; ?>
    </table>
<?php endif; ?>
