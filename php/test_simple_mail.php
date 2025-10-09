<?php
$to = "salimimehdibeti@gmail.com";
$subject = "Test From PHP mail()";
$message = "Dies ist ein Test.";
$headers  = "From: salimimehdibeti@gmail.com\r\n";
$headers .= "Content-Type: text/plain; charset=UTF-8\r\n";

if (mail($to, $subject, $message, $headers)) {
    echo "✅ Mail() says: sent";
} else {
    echo "❌ Mail() says: failed";
}
