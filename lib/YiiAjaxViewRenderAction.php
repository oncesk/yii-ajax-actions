<?php
class YiiAjaxViewRenderAction extends YiiAjaxBaseAction {

	/**
	 * @var string
	 */
	public $view;

	/**
	 * @var string
	 */
	public $layout;

	/**
	 * @var array
	 */
	public $scope = array();

	public function onBeforeViewRender() {}
	public function onAfterViewRender() {}

	public function run() {
		$this->responseType = 'text/html';

		if ($this->layout) {
			//  set layout
			$this->getController()->layout = $this->layout;
		}
		if (!$this->view) {
			//  if view not defined render current action view
			$this->view = $this->getId();
		}

		$this->raiseEvent('onBeforeViewRender', new CEvent($this));

		//  render view and set result to $response
		$this->response = $this->getController()->renderPartial($this->view, $this->scope, true);

		$this->raiseEvent('onAfterViewRender', new CEvent($this));

		parent::run();
	}
}