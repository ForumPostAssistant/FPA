<?php
/*
 * Language switcher
 */
?>
<fieldset class="langSelect"><legend><?php echo qText('Language'); ?></legend>
<?php

foreach($sfBuilderDefinedLanguages as $defLang => $name)
{
    $checked =($defLang == $lang) ? ' checked="checked"' : ''; ?>
	<input type="radio" name="lang" id="lng_<?php echo $defLang; ?>"
	onclick="submitform();" <?php echo $checked; ?>
	value="<?php echo $defLang; ?>" />
	<label for="lng_<?php echo $defLang; ?>">
		<?php echo $name; ?>
	</label><br />
<?php
}//foreach
?>
</fieldset>
<?php
