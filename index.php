<?php $config = require_once('config.php') ; ?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Deploy</title>
    <style>
        body {
            font-family: Arial, sans-serif;
            background-color: #f4f4f9;
            margin: 0;
            padding: 0;
            display: flex;
            justify-content: center;
            align-items: center;
            height: 100vh;
            flex-direction: column;
        }
        h1 {
            color: #333;
        }
        form {
            background: #fff;
            padding: 20px;
            border-radius: 8px;
            box-shadow: 0 0 10px rgba(0, 0, 0, 0.1);
            max-width: 400px;
            width: 100%;
            margin-bottom: 20px;
        }
        form label {
            display: block;
            margin-bottom: 5px;
            color: #555;
        }
        form select, form input[type="text"], form input[type="submit"] {
            width: 100%;
            padding: 10px;
            margin-bottom: 15px;
            border: 1px solid #ddd;
            border-radius: 5px;
            box-sizing: border-box;
        }
        form input[type="submit"] {
            background: #28a745;
            color: #fff;
            border: none;
            cursor: pointer;
        }
        form input[type="submit"]:hover {
            background: #218838;
        }
        iframe {
            background: #fff;
            border: 1px solid #ddd;
            border-radius: 5px;
            box-shadow: 0 0 10px rgba(0, 0, 0, 0.1);
            width: 70%;
            height: 400px;
            overflow: auto;
        }
    </style>
</head>
<body>
    <h1>Deploy a Branch</h1>
    <form action="deploy.php" method="POST" target="logFrame">
        <label for="project">Project:</label>
        <select id="project" name="project">
            <?php 
            asort($config['projects']);
            foreach($config['projects'] as $branch => $label):  ?>
            <option value="<?php echo $branch; ?>"> <?php echo $label;?></option>
            <?php endforeach; ?>
        </select>
        <label for="branch">Branch:</label>
        <input type="text" id="branch" name="branch" placeholder="Enter branch name (Default: main)" required>
        <input type="submit" value="Deploy">
    </form>
    <h2>Deployment Log:</h2>
    <iframe name="logFrame" id="logFrame"></iframe>

    <script>
        // Function to autoscroll the iframe to the bottom
        function autoScrollIframe() {
            var iframe = document.getElementById('logFrame');
            var iframeDocument = iframe.contentDocument || iframe.contentWindow.document;
            iframe.contentWindow.scrollTo(0, iframeDocument.body.scrollHeight);
        }
    
        // Listen for load event to initialize observer
        document.getElementById('logFrame').onload = function() {
            var iframe = document.getElementById('logFrame');
            var iframeDocument = iframe.contentDocument || iframe.contentWindow.document;
    
            // Observe changes to the iframe's content and scroll to the bottom
            var observer = new MutationObserver(autoScrollIframe);
            observer.observe(iframeDocument.body, { childList: true, subtree: true });
    
            // Scroll to the bottom initially after load
            autoScrollIframe();
        };
    </script>
    
</body>
</html>
