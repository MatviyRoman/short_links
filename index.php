<?php

error_reporting(0);

$title = 'Short links';
$host = $_SERVER['HTTP_HOST'];
$ajax = $_GET['ajax'];
$url = preg_replace("(^https?://)", "", htmlspecialchars($_POST['url']));
$hash = hash_hmac('sha256', "$url", "secretkey");
$result = substr($hash, 0, 5);
// echo '<pre>';
// print_r($_SERVER);

function connectDb($search = '', $query, $link_hash = '', $link_url = '')
{
    $servername = "localhost"; //server name
    $username = "link";        //user name
    $password = "5G4k1Q9x";    //user password
    $dbname = "link";          //db name

    try {
        $pdo = new PDO("mysql:host=$servername;dbname=$dbname", $username, $password);
        // set the PDO error mode to exception
        $pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
        // echo "Connected successfully";

        if ($search) {

            // print_r($pdo->query($search));

            $stmt = $pdo->prepare("SELECT * FROM short_links WHERE link_hash=? LIMIT 1");
            $stmt->execute([$link_hash]);
            $row = $stmt->fetch();
            // var_dump($row);

            if (!$row) {
                $sql = "INSERT INTO short_links (link_id, link_hash, link_url) VALUES (?,?,?)";
                $stmt = $pdo->prepare($sql);
                $stmt->execute([0, $link_hash, $link_url]);
            }
        } else if ($query) {
            // echo $query;
            foreach ($pdo->query($query) as $row) {
                Header('Status: 301 Moved Permanently');
                Header('Location: ' . $row['link_url']);
                $title = 'Redirect';
                $content = '<meta http-equiv="Refresh" content="0; url=' . htmlspecialchars($row['link_url']) . '">';
                $content .= '<script type="text/javascript">document.location.href=unescape("' . rawurlencode($row['link_url']) . '");</script>';
                $content .= '<a href="' . htmlspecialchars($row['link_url']) . '">Redirect...</a><br><br>';

                render_page($title, $content);
            }
        }
    } catch (PDOException $e) {
        echo "Connection failed: " . $e->getMessage();
    }
}

function render_page($title = '', $content)
{
?>
    <!DOCTYPE html>
    <html lang="en">

    <head>
        <meta charset="UTF-8">
        <meta http-equiv="X-UA-Compatible" content="IE=edge">
        <meta name="viewport" content="width=device-width, initial-scale=1.0">
        <title><?= $title ?></title>
        <link rel="stylesheet" href="style.css">
    </head>

    <body>
        <?= $content ?>
    </body>

    </html>
<?
}

$id = $_GET['id'];
if ($id) {

    $query = 'SELECT * FROM short_links WHERE link_hash = "' . $id . '" LIMIT 1';
    connectDb(false, $query);

    Header('Status: 301 Moved Permanently');

    $content = '<a href="https://' . htmlspecialchars($id) . '">Redirect...</a><br><br>';

    // echo $id;

    if (filter_var(gethostbyname($id), FILTER_VALIDATE_IP)) {
        Header('Location: https://' . $id);
        $content .= '<meta http-equiv="Refresh" content="0; url=https://' . htmlspecialchars($id) . '">';
        $content .= '<script type="text/javascript">document.location.href=unescape("https://' . rawurlencode($id) . '");</script>';
    }

    render_page($title = 'Go to', $content);
    exit();
}

if ($ajax && $url) {
    if (!filter_var(gethostbyname($url), FILTER_VALIDATE_IP)) {
        exit("https://$url is not a valid URL");
    }
    ob_end_clean();

    $search = 'SELECT * FROM short_links WHERE link_hash = "' . $result . '" LIMIT 1';
    $query = false;
    connectDb($search, $query, $result, $url);

    echo "Short url address: <input type='text' value='https://$host/$result'>";
    exit();
}

$content = "<h1><?= $title ?></h1>
    <form action=\"/\" method=\"post\">
        <input type=\"text\" id=\"url\" placeholder=\"url address\">
        <input type=\"submit\" value=\"short link\" id=\"submit\">
    </form>
    <div class=\"error\"></div>
    <div class=\"results\"></div>
    <div class=\"success\"></div>
    <script src=\"https://ajax.googleapis.com/ajax/libs/jquery/3.6.0/jquery.min.js\"></script>
    <script src=\"index.js\"></script>";

render_page($title, $content);
