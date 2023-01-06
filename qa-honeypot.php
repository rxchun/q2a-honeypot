<?php

class qa_html_theme_layer extends qa_html_theme_base {
	
	private $directory;
	private $honeypotClass = 'fGAWas6';

	public function load_module($directory, $urltoroot)
	{
		$this->directory = $directory;
	}
	
	function doctype(){
		// Check if it's a page with form
		if (($this->request=='register' || $this->request=='ask' || $this->request=='feedback') && !empty($this->content['form']['fields']) ) {
			// add checkbox
			$optionfield = array(
				'id'	=> $this->honeypotClass,
				'label' => '',
				'tags'	=> 'name="contact_me_by_fax_only" class="'. $this->honeypotClass .'" dir="auto" tabindex="-1" autocomplete="off" type="checkbox" value="1" checked="" style="display:none;"',
				'type' 	=> 'checkbox',
			);
			$this->content['form']['fields']['honeypot'] = $optionfield;
		}

		qa_html_theme_base::doctype();
	}
	
	

	function body_suffix() {
		qa_html_theme_base::body_suffix();
		
		$this->output_raw("
		<script>
			q2aFormCase = '\
				body.qa-template-register form,\
				body.qa-template-ask form,\
				body.qa-template-feedback form\
			';
			
			jQuery(document).on('submit', q2aFormCase, function(){
				if(jQuery('input.". $this->honeypotClass ."').prop('checked') != true){
					return false;
				} else  {
					return true;
				}
			});
		</script>
		");
	}

}