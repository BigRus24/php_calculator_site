<?php
declare(strict_types=1);
function manualHash(string $sensitiveData, string $salt) {
    $pepper = "ASecretPepperString";

    echo "<br>" ."sensitive data: ". $sensitiveData;
    echo "<br>" ."salt: ". $salt;
    echo "<br>" ."pepper: ". $pepper;

    $dataToHash = $sensitiveData . $salt . $pepper;
    $hash = hash("sha256", $dataToHash);

    echo "<br>" . "hash: $hash<br>";
    return $hash;
}
function verifyHash(string $sensitiveData, string $storedSalt, string $storedHash) {
    $pepper = "ASecretPepperString";
    
    $dataToHash = $sensitiveData . $storedSalt . $pepper;
    $verificationHash = hash("sha256", $dataToHash);
    echo "<br>" . "sensitiveData: $sensitiveData <br>";
    echo "<br>" . "verificationHash: $verificationHash <br>";
    echo "<br>" . "storedSalt: $storedSalt <br>";

    return ($storedHash === $verificationHash);
}