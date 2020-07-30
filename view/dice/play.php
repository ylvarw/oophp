<?php

namespace Anax\View;

/**
 * Render content within an article.
 */

// Show incoming variables and view helper functions
// echo showEnvironment(get_defined_vars(), get_defined_functions());



?><h1>Play Dice</h1>

<h3>Först till 100!!!</h3>
<br>
<?php if ($winner) : ?>
    <h2> <?= $winner ?> har uppnått 100 poäng!!</h2>
    <a href="<?= url("dice/restart")?>">Starta om spelet</a>
<?php endif; ?>

<p>Dina poäng: <?= $playerpoint ?></p>
<p>Datorns poäng: <?= $computerpoint ?> points</p>
<p>tärningslag: <?= $diceList ?>  </p>
<br>

<?php if (!$computerturn) : ?>
    <p>
        <!-- Ditt slag: <?= $diceList ?> <br>  -->
        dina poäng för rundan: <?= $diceSum ?> </>
        <form method="post">
            <input type="submit" name="save" value="spara">
        </form>
<?php endif; ?>

<?php if ($computerturn) : ?>
    <p>Datorns poäng denna rundan: <?= $diceSum ?> </>
<?php endif; ?>
<br>
<!-- <p><?= $turn ?> tur</p> -->
    <form method="post">
        <input type="submit" name="roll" value="Slå tärningar">
        <!-- <input type="submit" name="save" value="spara"> -->
        <!-- <input type="submit" name="restart" value="Nytt spel"> -->
    </form>

    <p>
        <a href="<?= url("dice/restart")?>">Starta om spelet</a>
    </p>
