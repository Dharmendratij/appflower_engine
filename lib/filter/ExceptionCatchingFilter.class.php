<?php

/**
 * A filter that catches all exceptions in POST requests
 * and converts them to a JSON error response.
 */
class ExceptionCatchingFilter extends sfFilter
{
	public function execute ($filterChain)
	{
            
		$request = $this->context->getRequest();
		if($request->isXmlHttpRequest() && $this->isFirstCall())
		{
                    
                    $debugMode = sfConfig::get('sf_debug');
			try {
				$filterChain->execute();
			} catch (sfException $e) {
				throw $e;
			} catch (PropelException $e) {
                            $cause = $e->getCause();
                            if ($cause->getCode() == 23000) {
                                if (!$debugMode) {
                                    $message = 'You are probably trying to delete or update a record that have other related records.';
                                }
                            } else if ($debugMode) {
                                $message = 'Database error occured.';
                            }
                            if (!isset($message)) {
                                $message = $e->getMessage();
                            }
                            $this->injectErrorIntoResponse($message);
			} catch (Exception $e) {
                            if ($debugMode) {
                                $errorMessage = $e->getMessage();
                            } else {
                                $errorMessage = 'Some unexpected error occured.';
                            }
                            $this->injectErrorIntoResponse($errorMessage);
			}
		} else {
			$filterChain->execute();
		}
	}

        private function injectErrorIntoResponse($errorMessage)
        {
            $debugMode = sfConfig::get('sf_debug');
            if ($debugMode) {
                $errorMessage = 'Unable to do the action.<br/>Reason: '.$errorMessage;
            } else {
                $errorMessage .= '<br/><br/>If you believe you found a bug - please let us know about it.';
            }

            $response = $this->context->getResponse();
            $params = array('success' => false, 'message' => $errorMessage);
            $response->setContent(json_encode($params));
        }
}
