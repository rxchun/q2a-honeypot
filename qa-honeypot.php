<?php

class qa_html_theme_layer extends qa_html_theme_base {
	
	private $directory;

	public function load_module($directory, $urltoroot)
	{
		$this->directory = $directory;
	}
	
	public function form_password($field, $style)
	{
		qa_html_theme_base::form_password($field, $style);
		
		if ($this->template === 'register') {
			$this->output_raw('<input name="contact_me_by_fax_only" class="q2ahoneypot" dir="auto" tabindex="-1" autocomplete="off" type="checkbox" value="1" checked="" style="display:none;">');
		}
	}

	function body_suffix() {
		qa_html_theme_base::body_suffix();

		$this->output_raw("
		<script>
			$(document).on('submit','body.qa-template-register form',function(){
				if($('input.q2ahoneypot').prop('checked') != true){
					return false;
				} else  {
					return true;
				}
			});
		</script>
		");
	}

}