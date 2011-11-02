/**
 * TEST Javascript file
 */

/**
 * Submit the ''admin form''
 */
function submitform(pressbutton) {
	frm = document.getElementById('adminForm');

	if (pressbutton) {
		frm.task.value = pressbutton;
	}

	if (typeof frm.onsubmit == "function") {
		frm.onsubmit();
	}

	frm.submit();
}

/**
 * Show/Hide Post Form.
 * 
 * @param showHideDiv
 * @param switchTextDiv
 * @returns
 */
function toggle2(showHideDiv, switchTextDiv) {
	var ele = document.getElementById(showHideDiv);
	var text = document.getElementById(switchTextDiv);

	if (ele.style.display == "block") {
		ele.style.display = "none";
		text.innerHTML = '<span style="font-size:12px;color:#4D8000;"><span style="font-size:18px;color:#008000;">&Theta;</span> Show the <strong><?php echo _RES; ?></strong></span>';
	} else {
		ele.style.display = "block";
		text.innerHTML = '<span style="font-size:12px;color:#800000;"><span style="font-size:20px;color:#800000;">&otimes;</span> Hide the <strong><?php echo _RES; ?></strong></span>';
	}
}
