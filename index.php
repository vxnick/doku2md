<?php
error_reporting(E_ALL);

function doku2md($source) {
	// Map DokuWiki regex to the Markdown replacements
	$replacements = array(
		'<\/?(code|pre)>' => '```', // Block code
		"''" => '`', // Inline code
		'\/\/(?=[^:])(.*?)\/\/' => '_$1_', // Italics (emphasis)
		'======' => '#', // Header 1
		'=====' => '##', // Header 2
		'====' => '###', // Header 3
		'===' => '####', // Header 4
		'==' => '#####', // Header 5
		'\[\[(.*)\|(.*)\]\]' => '[$2]($1)', // Links (with name)
		'\[\[(.*)\]\]' => '$1', // Links (without name)
	);

	foreach ($replacements as $match => $replacement) {
		$source = preg_replace('/'.$match.'/i', $replacement, $source);
	}

	return $source;
}

// Preview as plain text for convenience CTRL+A/CTRL+C'ing
if (isset($_POST['submit']) && !empty($_POST['source'])) {
	header('Content-Type: text/plain; charset=utf-8');
	echo doku2md($_POST['source']);
	exit;
}

?>

<form action="" method="post">
	<textarea name="source" cols="100" rows="50">
		<?php if (isset($_POST['source'])): ?>
			<?php echo htmlentities($_POST['source'], ENT_QUOTES, 'UTF-8') ?>
		<?php endif ?>
	</textarea><br />
	<input type="submit" name="submit" value="Convert" />
</form>