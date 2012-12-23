<meta HTTP-EQUIV="Refresh" CONTENT="5; URL=<?php echo $url; ?>">

<div style="margin: 0 auto; width: 500px; min-width: 500px; max-width: 500px; border: 1px solid #aaa; padding: 20px; text-align: center; margin-top: 60px; font: 14px Arial;">
	<?php if(isset($add) && $add): ?>
		Adres email <?php echo $email; ?> został dodany
	<?php endif; ?>
	<?php if(isset($delete) && $delete): ?>
		Adres email <?php echo $email; ?> został usunięty
	<?php endif; ?>
	<?php if(isset($valid) && $valid): ?>
		Error: Adres email <?php echo $email; ?> jest niepoprawny
	<?php endif; ?>
	<?php if(isset($validlist) && $validlist): ?>
		Error: Błędna lista mailingowa
	<?php endif; ?>

	<br /><br />
	Jeśli przeglądarka nie przekieruje Cię <br />na stronę powrotną w ciągu 5 sekund kliknij <a href="<?php echo $url; ?>">Tutaj</a>
</div>