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
    <label for="card">Carte</label>
    <select name="card" onchange="showDiv(this)" id="card">
        <option value="0" selected></option>
        <option value="1"<?php if ($card == 1) {echo ' selected';} ?>>Oui</option>
        <option value="0"<?php if ($card == 0) {echo ' selected';} ?>>Non</option>
    </select>
</div>
<div id="showIfCard">
    <label for="cardNumber">N° de carte</label>
    <input type="text" name="cardNumber" value="<?= $cardNumber ?>" maxlength="4">
</div>
<div id="viewIfCard">
    <label for="cardTypesId">Type de carte</label>
    <select name="cardTypesId">
        <option value="" selected></option>
        <option value="1"<?php if (isset($cardTypesId) && $cardTypesId == 1) {echo ' selected';} ?>>Fidélité</option>
        <option value="2"<?php if (isset($cardTypesId) && $cardTypesId == 2) {echo ' selected';} ?>>Famille Nombreuse</option>
        <option value="3"<?php if (isset($cardTypesId) && $cardTypesId == 3) {echo ' selected';} ?>>Etudiant</option>
        <option value="4"<?php if (isset($cardTypesId) && $cardTypesId == 4) {echo ' selected';} ?>>Employé</option>
    </select>
</div>
<label for="button">&nbsp;</label>

<script type="text/javascript">
function showDiv(elem){
    if (elem.value == 1) {
        document.getElementById('showIfCard').style.display = "block";
        document.getElementById('viewIfCard').style.display = "block";
    } else {
        document.getElementById('showIfCard').style.display = "none";
        document.getElementById('viewIfCard').style.display = "none";
    }
}
</script>
