<?php 
// FOrm builder
//Define each function to render form
function render_block_open($form){
global $app_prefix;
echo '
<div class="admin-wrapper">
<div class="block">
<div class="block-head"><h3 title="Click to toggle">'.$form['title'].'</h3><input type="submit" name="'.$app_prefix.'submit" value="Save Changes" class="button-secondary" title="Save Changes"/>
<div class="clearfix"></div>
</div>
<div class="slide-block">
';
}

function render_block_close(){
echo '</div></div></div>';
}

function render_text($form){
echo '
<div class="input-block">
<label for="'.$form['id'].'">'.$form['title'].'</label>
<input type="text" name="'.$form['id'].'" id="'.$form['id'].'" value="'.get_option($form['id']).'" />
<small>'.$form['desc'].'</small>
<div class="clearfix"></div>
</div>
';
}

function render_textarea($form){
echo '
<div class="input-block">
<label for="'.$form['id'].'">'.$form['title'].'</label>
<textarea name="'.$form['id'].'" id="'.$form['id'].'">'.stripslashes(get_option($form['id'])).'</textarea>
<small>'.$form['desc'].'</small>
<div class="clearfix"></div>
</div>
';
}
?>
