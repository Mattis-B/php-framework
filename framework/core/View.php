<?
class View {
	protected $THEME = [], $_content = [], $_title = '', $_outBuffer = [], $_viewName, $_controllerName, $_layout = 'default', $_tags, $_page, $_pageInfo, $_models = [];

	function __construct($controllerName){
		$this->_controllerName = strtolower($controllerName);
		@$this->_page = new DOMDocument();
		$this->_tags=[
			'match'=>[
				'admin'=>function($els){
					//if(USER['type']!=='Admin'){
						for($i = $els->length-1; $el = $els->item($i);--$i){
							$el->parentNode->removeChild($el);
						}
					//}
				}
			],
			'replace'=>[
				'<content:(.*)>'=>function($matches){
					return $this->content($matches[1]);
				}
			]
		];
	}

	function tags($tags, $override = false){
		foreach($tags['match'] as $tag=>$f){
			if(!isset($this->_tags['match'][$tag]) || $override){
				$this->_tags['match'][$tag] = $f;
			}
		}
		foreach($tags['replace'] as $tag=>$f){
			if(!isset($this->_tags['replace'][$tag]) || $override){
				$this->_tags['replace'][$tag] = $f;
			}
		}
	}

	function render($viewName){
		$this->_viewName = $viewName;
		if(file_exists(WEB_ROOT. "/views/$viewName/page.json")){
			getJSON(WEB_ROOT."/views/$viewName/page.json",$this->_pageInfo);
			if(isset($this->_pageInfo['layout'])) $this->layout($this->_pageInfo['layout']);
			if(empty($this->_layout)) {
				ob_start();
				require WEB_ROOT."/views/$viewName/index.php";
				$this->_page->loadHTML(ob_get_clean());
				$this->title();
				$this->_iModels();
				die($this->_page->saveHTML());
			}

			$this->THEME = json_decode($_COOKIE['theme'],true);
			if(file_exists(WEB_ROOT."/views/$this->_viewName/index.php")) require WEB_ROOT."/views/$this->_viewName/index.php";
			$this->parse($this->layout());
			$this->_iModels();
			$this->title();
			$page = $this->_page->saveHTML();
			die($page);
		} else {
			header('HTTP/1.0 404 Not Found');
			die();
		}
	}

	private function _iModels(){
		$head = $this->_page->getElementsByTagName('head')->item(0);
		foreach($this->_models as $model){
			if(file_exists(WEB_ROOT."/models/$model/style.css")){
				$styleEl = new DOMElement('style');
				ob_start();
				require WEB_ROOT."/models/$model/style.css";
				$styleEl->textContent = ob_get_clean();
				$head->insertBefore($styleEl,$head->firstChild);
			}
			if(file_exists(WEB_ROOT."/models/$model/script.js")){
				$scriptEl = new DOMElement('script');
				ob_start();
				require WEB_ROOT."/models/$model/script.js";
				$scriptEl->textContent = ob_get_clean();
				$head->insertBefore($scriptEl,$head->firstChild);
			}
		}
	}

	private function parse($page){
		ob_start();
		require $page;
		$html = ob_get_clean();
		foreach($this->_tags['replace'] as $tag=>$f){
			$html = preg_replace_callback(";$tag;i", $f, $html);
		}
		@$this->_page->loadHTML($html);
		foreach($this->_tags['match'] as $tag=>$f){
			$els = $this->_page->getElementsByTagName($tag);
			$f($els);
		}
	}

	function model($model) {
		if(!in_array($model, $this->_models)) $this->_models[] = $model;
		require WEB_ROOT."/models/$model/index.php";
	}

	function layout($layoutName = NULL){
		if($layoutName === NULL) return WEB_ROOT."/layouts/$this->_layout/index.php";
		$this->_layout = $layoutName;
	}

	protected function privilege($priv,$code){
		if(USER["privilege"]>$priv){
			echo $code;
			return true;
		}
		return false;
	}
	protected function type($type,$code){
		if(USER['type'] == $type){
			echo $code;
			return true;
		}
		return false;
	}

	function content($cont){
		ob_start();
		require WEB_ROOT."/views/$this->_viewName/$cont.php";
		return ob_get_clean();
	}

	function start($type){
		array_push($this->_outBuffer,$type);
		ob_start();
	}

	function end(){
		$this->_content[array_pop($this->_outBuffer)] = ob_get_clean();
	}

	function title(){
		$head = $this->_page->getElementsByTagName('head')->item(0);
		$title = new DOMElement('title');
		$title->textContent = SITE_NAME . (isset($this->_pageInfo['name']) ? (' - ' . $this->_pageInfo['name']) : '');
		$head->insertBefore($title, $head->firstChild);
	}

	function script($file){
		?>
		<script><? $this->_fileContent($file) ?></script>
		<?
	}
	function style($file){
		?>
		<style><? $this->_fileContent($file) ?></style>
		<?
	}
	public function fileContent(){
		$dir = explode('/',debug_backtrace()[0]['file']);
		array_pop($dir);
		$dir = implode('/',$dir);
		require $dir.$file;
	}
	private function _fileContent($file){
		$dir = explode('/',debug_backtrace()[1]['file']);
		array_pop($dir);
		$dir = implode('/',$dir).'/';
		require $dir.$file;
	}
}
