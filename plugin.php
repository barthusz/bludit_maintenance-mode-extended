<?php

class pluginMaintenanceModeExtended extends Plugin {
	
	private $loadOnController = array(
		'configure-plugin'
	    );

	public function init()
	{
		$this->dbFields = array(
			'enable'=>false,
			'message'=>'Temporarily down for maintenance.',
			'textcolor'=>'#ffffff',
			'bgcolor'=>'#00b1b3'
		);
	}
	
	public function adminBodyEnd()
	{

        if (in_array($GLOBALS['ADMIN_CONTROLLER'], $this->loadOnController)) {
		    global $url;
            $slug = basename( $url->uri());
            if($slug!=get_class($this)) return false;      
		    $html = '<script src="'.$this->htmlPath().'js/jscolor.js"></script>';
            return $html;
		}
        return false;

	}

	public function form()
	{
		global $L;

		$html  = '<div class="alert alert-primary" role="alert">';
		$html .= $this->description();
		$html .= '</div>';

		$html .= '<div>';
		$html .= '<label>'.$L->get('Enable maintenance mode extended').'</label>';
		$html .= '<select name="enable">';
		$html .= '<option value="true" '.($this->getValue('enable')===true?'selected':'').'>'.$L->get('maintenance-mode-enabled').'</option>';
		$html .= '<option value="false" '.($this->getValue('enable')===false?'selected':'').'>'.$L->get('maintenance-mode-disabled').'</option>';
		$html .= '</select>';
		$html .= '</div>';

		$html .= '<div>';
		$html .= '<label>'.$L->get('Backgroundcolor').'</label>';
		$html .= '<input name="bgcolor" id="bgcolor" class="jscolor" type="text" value="'.$this->getValue('bgcolor').'">';
		$html .= '</div>';

		$html .= '<div>';
		$html .= '<label>'.$L->get('Textcolor').'</label>';
		$html .= '<input name="textcolor" id="textcolor" class="jscolor" type="text" value="'.$this->getValue('textcolor').'">';
		$html .= '</div>';

		$html .= '<div>';
		$html .= '<label>'.$L->get('Message extended').'</label>';
		$html .= '<input name="message" id="jsmessage" type="text" value="'.$this->getValue('message').'">';
		$html .= '</div>';

		return $html;
	}

	public function beforeSiteLoad()
	{
		if ($this->getValue('enable')) {

			$login = new Login();

			if($login->role()!=='admin' && $login->role()!=='editor') {

				$offline = "<div style='height: 100%; margin: 0; padding: 0; background: #".$this->getValue('bgcolor')." ; color: #".$this->getValue('textcolor')."; font-family: sans-serif; display: flex; align-items: center; justify-content: center;'>";
				$offline .= "<h1>".$this->getValue('message')."</h1>";
				$offline .= "</div>";

				echo $offline;
				exit();
			}

		}
	}
}