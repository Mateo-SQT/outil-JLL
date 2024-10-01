<?php
// Chemin vers votre script Python
$pythonScriptPath = '../../src/python/shp.py';

// Exécution du script Python
exec("python3 $pythonScriptPath", $output, $return_var);

// Retourner la sortie du script Python
echo implode("\n", $output);
?>
