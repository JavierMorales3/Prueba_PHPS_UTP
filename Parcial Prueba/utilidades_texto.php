<?php

function contar_palabras($texto) {
    // Cuenta el número de palabras en la cadena.
    // Utiliza la función str_word_count que cuenta las palabras de una cadena.
    return str_word_count($texto);
}

function contar_vocales($texto) {
    // Convierte el texto a minúsculas para un conteo no sensible a mayúsculas.
    $texto_minusculas = strtolower($texto);
    // Usa un patrón de expresión regular para encontrar todas las vocales.
    // preg_match_all devuelve el número de coincidencias.
    return preg_match_all('/[aeiouáéíóúü]/', $texto_minusculas, $matches);
}

function invertir_palabras($texto) {
    // Divide la cadena en un array de palabras.
    $palabras = explode(' ', $texto);
    // Invierte el orden de los elementos del array.
    $palabras_invertidas = array_reverse($palabras);
    // Une el array invertido en una nueva cadena separada por espacios.
    return implode(' ', $palabras_invertidas);
}

?>