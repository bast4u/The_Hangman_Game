<?php

require_once './lib/debug.php';

// Mon dictionnaire de mots
const DICO = [
    'carabistouille',
    'calembredaine',
    'bilevesée',
    'coxigrue',
    'cacochyme',
    'prolégomène',
    'calembour',
    'parthénogenèse',
    'antépénultième',
    'aréopage',
    'paracétamol',
    'cucurbitacées',
    'coloquinte',
    'vernaculaire',
];

/**
 * Renvoie un mot choisi aléatoirement dans le  DICO
 *
 * @return string Un mot du dictionnaire
 */
function getRandomWord(): string
{
    // On génère un index aléatoire d'un mot dans DICO grâce à la fonction array_rand
    $index = array_rand(DICO);
    // On retourne le mot correspondant à l'index aléatoire
    return DICO[$index];
}

/**
 * Renvoie la position d'un mot dans le DICO
 *
 * @param string $word Le mot à chercher dans le DICO
 * @return integer L'index du mot dans le DICO
 */
function getIndexOfWord(string $word): int|false
{
    // On va chercher l'index des mots du tableau grâce à la fonction array_search
    $index = array_search($word, DICO);
    // On retourne l'index du mot en paramètre ou null
    return $index ?? false;
}

/**
 * Renvoie le nombre de lettres erronées dans les propositions du joueurs
 * 
 * @param string $propositions Toutes les lettres tapées par le joueur jusqu'ici
 * @param string $word Le mot à trouver
 * @return integer Le nombre de lettres erronées
 */
function countErrors(string $propositions, string $word): int
{
    // Permet de retirer les accents de tous les mots contenus dans le dictionnaire
    $search  = array('À', 'Á', 'Â', 'Ã', 'Ä', 'Å', 'Ç', 'È', 'É', 'Ê', 'Ë', 'Ì', 'Í', 'Î', 'Ï', 'Ò', 'Ó', 'Ô', 'Õ', 'Ö', 'Ù', 'Ú', 'Û', 'Ü', 'Ý', 'à', 'á', 'â', 'ã', 'ä', 'å', 'ç', 'è', 'é', 'ê', 'ë', 'ì', 'í', 'î', 'ï', 'ð', 'ò', 'ó', 'ô', 'õ', 'ö', 'ù', 'ú', 'û', 'ü', 'ý', 'ÿ');
    $replace = array('A', 'A', 'A', 'A', 'A', 'A', 'C', 'E', 'E', 'E', 'E', 'I', 'I', 'I', 'I', 'O', 'O', 'O', 'O', 'O', 'U', 'U', 'U', 'U', 'Y', 'a', 'a', 'a', 'a', 'a', 'a', 'c', 'e', 'e', 'e', 'e', 'i', 'i', 'i', 'i', 'o', 'o', 'o', 'o', 'o', 'o', 'u', 'u', 'u', 'u', 'y', 'y');
    $word = str_replace($search, $replace, $word);

    // Au début de la partie le nombre d'erreurs est de 0
    $errors = 0;

    // Boucle qui va compter le nombre d'erreurs à chaque fois qu'une lettre soumise n'a pas d'occurence dans le mot à trouver
    for ($i = 0; $i < strlen($propositions); $i++) {
        // Si la lettre n'est pas trouvée il s'agit d'une erreur
        if (stripos($word, $propositions[$i]) === false) {
            $errors++;
        }
    }
    return $errors;
}

/**
 * Renvoie une chaîne représentant les lettres déjà trouvées dans le mot
 * Chaque lettre non trouvée est remplacée par un '_' (underscore)
 *
 * @param string $propositions Les lettres tapées par le joueur jusqu'ici
 * @param string $word Le mot à trouver
 * @return string La chaîne d'indices finale
 */
function getClueString(string $propositions, string $word): string
{
    // Permet de retirer les accents de tous les mots contenu dans la constante DICO
    $search  = array('À', 'Á', 'Â', 'Ã', 'Ä', 'Å', 'Ç', 'È', 'É', 'Ê', 'Ë', 'Ì', 'Í', 'Î', 'Ï', 'Ò', 'Ó', 'Ô', 'Õ', 'Ö', 'Ù', 'Ú', 'Û', 'Ü', 'Ý', 'à', 'á', 'â', 'ã', 'ä', 'å', 'ç', 'è', 'é', 'ê', 'ë', 'ì', 'í', 'î', 'ï', 'ð', 'ò', 'ó', 'ô', 'õ', 'ö', 'ù', 'ú', 'û', 'ü', 'ý', 'ÿ');
    $replace = array('A', 'A', 'A', 'A', 'A', 'A', 'C', 'E', 'E', 'E', 'E', 'I', 'I', 'I', 'I', 'O', 'O', 'O', 'O', 'O', 'U', 'U', 'U', 'U', 'Y', 'a', 'a', 'a', 'a', 'a', 'a', 'c', 'e', 'e', 'e', 'e', 'i', 'i', 'i', 'i', 'o', 'o', 'o', 'o', 'o', 'o', 'u', 'u', 'u', 'u', 'y', 'y');
    $word = str_replace($search, $replace, $word);

    // Initialisation d'une variable mot caché pour y stocker les underscores et lettres trouvées
    $hiddenWord = '';

    // Parcourt chaque lettre du mot
    for ($i = 0; $i < strlen($word); $i++) {
        // on stock la lettre du mot dans la variable letter
        $letter = $word[$i];
        // vérifie si la lettre se trouve dans la chaîne de propositions
        if (strpos($propositions, $letter) !== false) {
            // si la lettre est trouvée, elle est révélée
            $hiddenWord .= $letter;
        } else {
            // Si la lettre n'est pas trouvée, un underscore est ajouté
            $hiddenWord .= '_';
        }
    }
    return $hiddenWord;
}