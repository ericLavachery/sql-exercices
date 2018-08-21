<div>
    <label for="firstName">Prénom</label>
    <input type="text" name="firstName" value="<?= $firstName ?>">
</div>
<div>
    <label for="lastName">Nom</label>
    <input type="text" name="lastName" value="<?= $lastName ?>">
</div>
<div>
    <label for="birthDate">Date de naissance</label>
    <input type="text" name="birthDate" value="<?= $formBD ?>" placeholder="jj/mm/aaaa">
</div>
<div>
    <label for="card">Carte de fidélité</label>
    <select name="card">
        <option value="0" selected></option>
        <option value="1"<?php if ($card == 1) {echo ' selected';} ?>>Oui</option>
        <option value="0"<?php if ($card == 0) {echo ' selected';} ?>>Non</option>
    </select>
</div>
<div>
    <label for="cardNumber">N° de carte</label>
    <input type="text" name="cardNumber" value="<?= $cardNumber ?>" maxlength="4">
</div>
<label for="button">&nbsp;</label>
