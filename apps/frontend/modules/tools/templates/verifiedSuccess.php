<div style="margin: 0 auto; width: 500px; min-width: 500px; max-width: 500px; border: 1px solid #aaa; padding: 20px; text-align: center; margin-top: 60px; font: 14px Arial;">
	<?php if($ok): ?>
		Email <?php echo $email; ?> został poprawnie zweryfikowany
	<?php else: ?>
		Error: wystąpił błąd
	<?php endif; ?>
</div>