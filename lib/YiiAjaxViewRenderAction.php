<?php
class YiiAjaxViewRenderAction extends YiiAjaxBaseAction {

	/**
	 * @var bool
	 */
	public $enableViewRender = true;

	/**
	 * @var bool
	 */
	public $mergeResponseWithScope = true;

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
		if ($this->enableViewRender) {
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

			if ($this->mergeResponseWithScope) {
				$this->scope = array_merge($this->scope, $this->response);
			}

			//  render view and set result to $response
			$this->response = $this->getController()->renderPartial($this->view, $this->scope, true);

			$this->raiseEvent('onAfterViewRender', new CEvent($this));
		}
		parent::run();
	}
}