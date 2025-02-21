<?php
echo "Server time: " . time() . "<br>";
echo "Last activity: " . strtotime($contact['last_activity']) . "<br>";
echo "Diff: " . (time() - strtotime($contact['last_activity'])) . " seconds<br>";

