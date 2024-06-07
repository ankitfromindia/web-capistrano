<?php
$config = require_once('config.php');
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $project = escapeshellarg($_POST['project']);
    
    $branch = empty($_POST['branch']) ? 'main' : escapeshellarg($_POST['branch']);

    // Define the Capistrano path for the selected project
    $capistranoPath = $config['capistrano_path'];

    // Change directory to the Capistrano path
    chdir($capistranoPath);

    // Disable output buffering
    ini_set('output_buffering', 'off');
    ini_set('zlib.output_compression', false);

    // Command to run Capistrano
    $command = "git checkout $project && cap production deploy BRANCH=$branch";

    // Open the process
    $process = proc_open($command, [
        1 => ['pipe', 'w'], // stdout
        2 => ['pipe', 'w']  // stderr
    ], $pipes);

    if (is_resource($process)) {
        // Output the deployment logs
        while ($line = fgets($pipes[1])) {
            echo $line . "<br>";
            ob_flush();
            flush();
        }
        while ($line = fgets($pipes[2])) {
            echo $line . "<br>";
            ob_flush();
            flush();
        }

        // Close the pipes and the process
        fclose($pipes[1]);
        fclose($pipes[2]);
        proc_close($process);
    } else {
        echo "Failed to start deployment process.";
    }
} else {
    echo "Invalid request method.";
}
?>
