<?php
class YiiAjaxBaseAction extends CAction {

	/**
	 * @var mixed
	 */
	public $response;

	/**
	 * @var string
	 */
	public $responseType = 'text/json';

	public function onBeforeEnd() {}

	public function run() {
		$this->raiseEvent('onBeforeEnd', new CEvent($this));

		if ($this->responseType == 'text/json') {
			echo json_encode($this->response);
		} else if ($this->responseType == 'text/html') {
			echo $this->response;
		} else {
			if (is_array($this->response)) {
				echo json_encode($this->response);
			} else {
				if (is_string($this->response)) {
					echo $this->response;
				}
			}
		}
		Yii::app()->end();
	}
}