<?php

class pluginMaintenanceModeExtended extends Plugin {

	public function init()
	{
		$this->dbFields = array(
			'enable'=>false,
			'message'=>'Temporarily down for maintenance.',
			'textcolor'=>'#ffffff',
			'bgcolor'=>'#00b1b3'
		);
	}

	public function form()
	{
		global $L;

		$html  = '<div class="alert alert-primary" role="alert">';
		$html .= $this->description();
		$html .= '</div>';

		$html .= '<div>';
		$html .= '<label>'.$L->get('Enable maintenance mode').'</label>';
		$html .= '<select name="enable">';
		$html .= '<option value="true" '.($this->getValue('enable')===true?'selected':'').'>Aan</option>';
		$html .= '<option value="false" '.($this->getValue('enable')===false?'selected':'').'>Uit</option>';
		$html .= '</select>';
		$html .= '</div>';

		$html .= '<div>';
		$html .= '<label>'.$L->get('Backgroundcolor').'</label>';
		$html .= '<input name="bgcolor" id="bgcolor" type="text" value="'.$this->getValue('bgcolor').'">';
		$html .= '</div>';

		$html .= '<div>';
		$html .= '<label>'.$L->get('Textcolor').'</label>';
		$html .= '<input name="textcolor" id="textcolor" type="text" value="'.$this->getValue('textcolor').'">';
		$html .= '</div>';

		$html .= '<div>';
		$html .= '<label>'.$L->get('Message').'</label>';
		$html .= '<input name="message" id="jsmessage" type="text" value="'.$this->getValue('message').'">';
		$html .= '</div>';

		return $html;
	}

	public function beforeAll()
	{
		if ($this->getValue('enable')) {
			$offline = "<div style='height: 100%; margin: 0; padding: 0; background:".$this->getValue('bgcolor')." ; color: ".$this->getValue('textcolor')."; font-family: sans-serif; display: flex; align-items: center; justify-content: center;'>";
			$offline .= "<h1>".$this->getValue('message')."</h1>";
			$offline .= "</div>";

			echo $offline;
			exit();
			//exit( $this->getValue('message') );
		}
	}
}