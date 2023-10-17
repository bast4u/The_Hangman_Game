<?php
require_once './lib/hangman.php';

// initialisation des variables
$letter         = '';       // la lettre qui vient d'être saisie par l'utilisateur (si pas le premier round)
$propositions   = '';       // chaîne de caractères regroupant l'ensemble de toutes les propositions faites par le joueur jusqu'ici
$index          = -1;       // index du mot à trouver dans le dictionnaire dico
$word           = '';       // le mot à trouver choisi aléatoirement dans le dico et retrouvé à chaque tour grâce à l'index
$clueString     = '';       // la chaîne à afficher au joueur pour lui indiquer l'enplacement des lettres déjà trouvées (les lettres non trouvées sont replacées par des '_')
$nbErrors       = 0;        // nombre d'erreurs faites jusqu'ici par le joueur (à 6, c'est game over)
$lost           = false;    // true si le joueur a perdu
$won            = false;    // true si le joueur a gagné
$clueCSSClass   = '';       // classe css à ajouter à la cluestring on fonction de la longueur du mot (pour que cela rentre dans l'écran)

// vérification d'existence de la lettre dans le formulaire
if(isset($_POST['letter'])){
    // Récupération de la valeur dans une variable
    $letter = $_POST['letter'];
    // Passage en minuscule
    $letter = strtolower($letter);
    // Condition : une et une unique lettre
    if(strlen($letter) != 1){
    // S'il y a plus ou moins d'une lettre, la variable est vidée
    $letter = '';
    }
    // Vérificiation de l'appartenance de la lettre à l'alphabet (on ne veut pas de chiffres ou caractères spéciaux)
    if(!in_array($letter, range('a', 'z'))){
    // Si ce n'est pas une lettre de l'alphabet, on vide la variable
    $letter = '';
    }
}

// vérification d'existence de l'index dans le formulaire
if(isset($_POST['index'])){
    // Récupération de la valeur dans une variable
    $index = $_POST['index'];
} 
// vérification d'existence de la chaîne de proposition dans le formulaire
if(isset($_POST['propositions'])){
    // Récupération de la valeur dans une variable
    $propositions = $_POST['propositions'];
}

// Si on commence une partie (index est égal à -1)
if($index == -1){
    // on va chercher un mot aléatoire
    $word = getRandomWord(DICO);
    // on va chercher l'index du mot aléatoire
    $index = getIndexOfWord($word);
    // CETTE VARAIBLE DEVRA ÊTRE STOCKÉE DANS LE HTML SOUS LA FORME D'UN INPUT TYPE HIDDEN POUR POUVOIR ÊTRE RETROUVÉ PLUS TARD LORS DES ROUNDS SUIVANTS
}  

// Si la lettre que l'utilisateur vient de saisir n'est pas déjà dans les propositions précédentes
if (strpos($propositions, $letter) === false) {
    // on concatene cette lettre aux propositions précédentes
    $propositions .= $letter;
}

// Si l'index est valide
if ($index >= 0 && $index <= count(DICO)) {
    // On récupère le mot dans le dico en utilisant l'index
    $word = DICO[$index];
} else {
    echo '';
}

// Appel de la fonction getClueString, qui remplace les lettres non trouvées dans un mot par des underscores
$clueString = getClueString($propositions, $word);

// Appel de la fonction countErrors qui compte le nombre d'erreurs du joueur
$nbErrors = countErrors($propositions, $word);

// Si le joueur fait 6 erreurs ou plus
if($nbErrors >= 6){
    // Il perd
    $lost = true;
}

// Si la cluestring ne contient plus d'underscore, c'est que toutes les lettres ont été trouvées
if(strpos($clueString, '_') === false){
    // le joueur a fonc gagné
    $won = true;
}

// Ceci concerne l'affichage uniquement //

// si le mot fait plus de 9 caractères
if (strlen($word) > 9) {
    // ecrire 'clue-small' dans $cluecssclass
    $clueCSSClass = 'clue-small';
    // sinon si le mot fait plus de 12 caractères
} elseif (strlen($word) > 12) {
    // ecrire 'clue-tiny' dans $cluecssclass
    $clueCSSClass = 'clue-tiny';
}

// CHARGEMENT DE LA VUE
include './templates/index.phtml';