<div>
    <label for="name">Name</label>
    <input type="text" name="name" value="<?= $name ?>">
</div>
<div>
    <label for="difficulty">Difficulté</label>
    <select name="difficulty">
        <option value="très facile"<?php if ($difficulty == 'très facile') {echo ' selected';} ?>>Très facile</option>
        <option value="facile"<?php if ($difficulty == 'facile') {echo ' selected';} ?>>Facile</option>
        <option value="moyen"<?php if ($difficulty == 'moyen') {echo ' selected';} ?>>Moyen</option>
        <option value="difficile"<?php if ($difficulty == 'difficile') {echo ' selected';} ?>>Difficile</option>
        <option value="très difficile"<?php if ($difficulty == 'très difficile') {echo ' selected';} ?>>Très difficile</option>
    </select>
</div>
<div>
    <label for="distance">Distance</label>
    <input type="text" name="distance" value="<?= $distance ?>">
</div>
<div>
    <label for="duration">Durée</label>
    <input type="duration" name="duration" value="<?= $duration ?>">
</div>
<div>
    <label for="height_difference">Dénivelé</label>
    <input type="text" name="height_difference" value="<?= $height ?>">
</div>
