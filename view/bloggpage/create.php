<?php
namespace Anax\View;

if (!$resultset) {
    return;
}

?>

<h1>skapa nytt inlägg</h1>

<?php if ($slugTest) : ?>
    <p>slug is already taken, please choose annother slug</p>
<?php endif; ?>



<?php if (!$contentTitle) : ?>
    <form method="post">
        <fieldset>
            <legend>Create New</legend>
            <p>
                <label>Title:<br> 
                <input type="text" name="contentTitle" required/>
                </label>
            </p>
            <p>
                <button type="submit" name="doCreate"><i class="fa fa-floppy-o" aria-hidden="true"></i> Save</button>
            </p>
        </fieldset>
    </form>
<?php endif; ?>


<?php if ($contentId) : ?>
    <form method="post">
        <fieldset>
        <legend>Edit content</legend>
        <input type="hidden" name="contentId" value="<?$contentId?>"/>

        <p>
            <label>Title:<br> 
            <input type="text" name="contentTitle" value="<?$contentTitle?>"/>
            </label>
        </p>

        <p>
            <label>Path:<br> 
            <input type="text" name="contentPath"/>
        </p>

        <p>
            <label>Slug:<br> 
            <input type="text" name="contentSlug"/>
        </p>

        <p>
            <label>Text:<br> 
            <textarea name="contentData"></textarea>
        </p>

        <p>
            <label>Type: (post/page)<br> 
            <input type="text" name="contentType"/>
        </p>

        <p>
            <label>Filter:<br> 
            <input type="text" name="contentFilter"/>
        </p>

        <p>
            <label>Publish:<br> 
            <input type="datetime-local" name="contentPublish"/>
        </p>

        <p>
            <button type="submit" name="doSave"><i class="fa fa-floppy-o" aria-hidden="true"></i> Save</button>
            <!-- <button type="reset"><i class="fa fa-undo" aria-hidden="true"></i> Reset</button> -->
            <!-- <button type="submit" name="doDelete"><i class="fa fa-trash-o" aria-hidden="true"></i> Delete</button> -->
        </p>
        </fieldset>
    </form>

    <p>
        <b>Filter:</b><br>
        <b><i>markdown:</i></b> Formattering enligt Markdown. <br>
        <b><i>nl2br:</i></b> Ersätt varje nyrad med en breakline.<br>
        <b><i>bbcode:</i></b> gör att användaren inte skall kunna skriva HTML-kod. <br>
        <b><i>link:</i></b> Gör länkar som skrivs i texten klickbara.<br>
        <br>
        använd filter i en comma separerad lista ex: bbcode,markdown,nl2br.
    </p>
<?php endif; ?>