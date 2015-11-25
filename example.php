<?php
include 'GoogleSpeechToText.php';

// Your API Key goes here.
$apiKey = 'AIzaSyCbBqke_xLXiUFZd8rPuJiGJA5mnhqPeSM';
$speech = new GoogleSpeechToText($apiKey);
$file = realpath('./uploads/output.flac'); // Full path to the file.
$bitRate = 44100; // The bit rate of the file.
$result = $speech->process($file, $bitRate, 'en-US');
var_dump($result);
