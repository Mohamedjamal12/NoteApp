<?php session_start();
if(empty($_SESSION['id'])):
header('Location:login.php');
endif;




if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    if (!empty($_POST['note'])) {
        $note = sanitizeInput($_POST['note']);
        saveNoteToFile($note);
    }
}


if (isset($_GET['delete'])) {
    $deletehome = $_GET['delete'];
    deleteNoteFromFile($deletehome);
}


if (isset($_GET['edit'])) {
    $edithome = $_GET['edit'];
    $editNote = getNoteFromFile($edithome);
}


if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['edit_note'])) {
    if (!empty($_POST['edited_note'])) {
        $editedNote = sanitizeInput($_POST['edited_note']);
        editNoteInFile($_POST['edit_note'], $editedNote);
    }
}


$notes = getNotesFromFile();

function sanitizeInput($input) {
 
    $sanitizedInput = filter_var($input, FILTER_SANITIZE_STRING);
    return $sanitizedInput;
}

function saveNoteToFile($note) {
    file_put_contents('notes.txt', $note . PHP_EOL, FILE_APPEND);
}

function deleteNoteFromFile($home) {
    $notes = getNotesFromFile();

    if (isset($notes[$home])) {
        unset($notes[$home]);
        file_put_contents('notes.txt', implode(PHP_EOL, $notes));
    }
}

function getNoteFromFile($home) {
    $notes = getNotesFromFile();

    return isset($notes[$home]) ? $notes[$home] : null;
}

function editNoteInFile($home, $editedNote) {
    $notes = getNotesFromFile();

    if (isset($notes[$home])) {
        $notes[$home] = $editedNote;
        file_put_contents('notes.txt', implode(PHP_EOL, $notes));
    }
}

function getNotesFromFile() {
    if (file_exists('notes.txt')) {
        $notes = file('notes.txt', FILE_IGNORE_NEW_LINES | FILE_SKIP_EMPTY_LINES);
        return $notes ? array_reverse($notes) : [];
    }

    return [];
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>PHP Notes App</title>
	<style>
	
         ul {
            list-style: none;
            padding: 0;
        }

        li {
            margin-bottom: 10px;
            padding: 10px;
            border: 1px solid #ccc;
            border-radius: 5px;
            position: relative;
        }
        .action-buttons {
            position: absolute;
            top: 5px;
            right: 5px;
        }
		button {
         padding: 8px 16px;
  background-color: #3498db;
  color: white;
  border: none;
  border-radius: 4px; 
  cursor: pointer;
  transition: background-color 0.3s ease; 
}
	</style>


</head>
<body style="background-color:#B3ADAB">
    <h1>Welcome, <?php echo htmlspecialchars($_SESSION['username']); ?>!</h1>

    
    <form action="logout process.php" method="post">
        <button type="submit">Logout</button>
    </form>

    
    <form action="home.php" method="post">
        <?php if (isset($edithome) && isset($editNote)) : ?>
            <input type="hidden" name="edit_note" value="<?php echo $edithome; ?>">
            <label for="edited_note">Edit Note:</label>
            <input type="text" name="edited_note" value="<?php echo htmlspecialchars($editNote); ?>" required>
            <button type="submit">Save Edit</button>
        <?php else : ?>
            <label for="note">Add Note:</label>
            <input type="text" name="note" required>
            <button type="submit">Add</button>
        <?php endif; ?>
    </form>

    
    <h2>Note List</h2>
    <ul>
        <?php foreach ($notes as $home => $note) : ?>
            <li>
                <?php echo htmlspecialchars($note); ?>
                <a href="home.php?edit=<?php echo $home; ?>">Edit</a>
                <a href="home.php?delete=<?php echo $home; ?>">Delete</a>
            </li>
        <?php endforeach; ?>
    </ul>
</body>
</html>