<?php
// Display a simple greeting
echo "Hello, welcome to my PHP page!<br>";

// Define variables
$name = "Ali";
$age = 20;

// Use conditional statements
if ($age >= 18) {
    echo "$name is an adult.<br>";
} else {
    echo "$name is a minor.<br>";
}

// Define a function
function greet($person) {
    return "Have a great day, $person!<br>";
}

// Call the function
echo greet($name);
?>

