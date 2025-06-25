<?php

class qa_html_theme_layer extends qa_html_theme_base {
	
	private $honeypotClassText;
	private $honeypotClassCheckbox;

	protected function isFormPageWithFields()
	{
		$formPages = ['register', 'ask', 'feedback'];

		return in_array($this->request, $formPages)
			&& !empty($this->content['form']['fields']);
	}
	
	function doctype()
	{
		// Generate and store the honeypot class name
		$this->honeypotClassText = $this->generateHoneypotClassName();
		$this->honeypotClassCheckbox = $this->generateHoneypotClassName();

		// Check if current page is one with a form
		if ($this->isFormPageWithFields()) {
			$this->content['form']['fields']['honeypot_text'] = [
				'id'    => $this->honeypotClassText,
				'label' => '',
				'tags'  => 'name="' . $this->honeypotClassText . '" class="' . $this->honeypotClassText . '" ' .
						'type="text" style="display:none;" tabindex="-1" autocomplete="off"',
				'type'  => 'text',
			];
			
			$this->content['form']['fields']['honeypot_checkbox'] = [
				'id'    => $this->honeypotClassCheckbox. '" style="display:none;',
				'label' => '',
				'tags'  => 'name="contact_me_by_fax_only" class="' . $this->honeypotClassCheckbox . '" ' .
						'type="checkbox" autocomplete="off" dir="auto" tabindex="-1" value="1" checked="" style="display:none;"',
				'type'  => 'checkbox',
			];
		}

		// Call base doctype
		parent::doctype();
	}
	
	protected function generateHoneypotClassName()
	{
		$letters = 'abcdefghijklmnopqrstuvwxyz';

		// Start with a letter
		$prefix = $letters[random_int(0, strlen($letters) - 1)];

		return $prefix . bin2hex(random_bytes(5));
	}
	
	function body_hidden()
	{
		parent::body_hidden();

		if ($this->isFormPageWithFields()) {
			$textClass = json_encode($this->honeypotClassText);
			$checkboxClass = json_encode($this->honeypotClassCheckbox);

			$this->output("
			<script>
			(function() {
				const textClass = {$textClass};
				const checkboxClass = {$checkboxClass};
				const formSelector = 'body.qa-template-register form, body.qa-template-ask form, body.qa-template-feedback form';

				document.querySelectorAll(formSelector).forEach(form => {
					form.addEventListener('submit', function(e) {
						const textField = form.querySelector('input.' + textClass);
						const checkbox = form.querySelector('input.' + checkboxClass);

						// If text field is filled OR checkbox is not checked → block
						if ((textField && textField.value !== '') || (checkbox && !checkbox.checked)) {
							e.preventDefault();
						}
					});
				});
			})();
			</script>
			");
		}
	}
}