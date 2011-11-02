<?php
/*
 * Language switcher
 */
?>
<fieldset class="langSelect"><legend><?php echo qText('Language'); ?></legend>
<ul>
<?php

foreach($sfBuilderDefinedLanguages as $defLang => $name)
{
    $active =($defLang == $lang) ? 'active' : ''; ?>
    <li>
        <a class="<?php echo $active; ?>" title="<?php echo $name; ?>" href="#" onclick="var frm=document.getElementById('adminForm'); frm.lang.value='<?php echo $defLang; ?>'; frm.submit();"><?php echo $defLang; ?></a>
    </li>
    <!--
	<input type="radio" name="langx" id="lng_<?php echo $defLang; ?>"
	onclick="submitform();" <?php echo $checked; ?>
	value="<?php echo $defLang; ?>" />
	<label for="lng_<?php echo $defLang; ?>">
		<?php echo $name; ?>
	</label><br />
     -->
<?php
}//foreach
?>
</ul>
<input type="hidden" name="lang" value="<?php echo $lang; ?>"/>
</fieldset>
<?php
