<?php $input = $request->get('name', 'World'); ?>
Hello, <?php echo htmlspecialchars($input, ENT_QUOTES, 'UTF-8'); ?>
