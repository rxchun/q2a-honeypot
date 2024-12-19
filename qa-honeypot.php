<?php

class qa_html_theme_layer extends qa_html_theme_base {
	
	function doctype()
	{
		// Generate random Class name
		global $honeypotClass;
		$honeypotClass = substr(str_shuffle('abcdefghijklmnopqrstuvwxyz'), 1, 1) . substr(str_shuffle('0123456789ABCDEFGHIJKLMNOPQRSTUVWXYZ'), 1, 9);
		
		// Check if it's a page with form
		if (($this->request=='register' || $this->request=='ask' || $this->request=='feedback') && !empty($this->content['form']['fields']) ) {
			// add checkbox
			$optionfield = array(
				'id'	=> $honeypotClass. '" style="display:none;',
				'label' => '',
				'tags'	=> 'name="contact_me_by_fax_only" class="'. $honeypotClass .'" dir="auto" tabindex="-1" autocomplete="off" type="checkbox" value="1" checked="" style="display:none;"',
				'type' 	=> 'checkbox',
			);
			$this->content['form']['fields']['honeypot'] = $optionfield;
		}

		qa_html_theme_base::doctype();
	}
	
	function body_suffix()
	{
		qa_html_theme_base::body_suffix();
		
		global $honeypotClass;
		
		$this->output_raw("
		<script>
			q2aFormCase = '\
				body.qa-template-register form,\
				body.qa-template-ask form,\
				body.qa-template-feedback form\
			';
			
			jQuery(document).on('submit', q2aFormCase, () => {
				if(jQuery('input.". $honeypotClass ."').prop('checked') != true) {
					return false;
				} else  {
					return true;
				}
			});
		</script>
		");
	}
	
}