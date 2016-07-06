<?php


namespace Eva\Crud;


use Psr\Http\Message\ResponseInterface;
use Psr\Http\Message\ServerRequestInterface;

abstract class ReadAction extends AbstractAction
{
    /**
     * @var ServerRequestInterface
     */
    protected $request;

    /**
     * @var ResponseInterface
     */
    protected $response;
    
    public function __invoke(ServerRequestInterface $request, ResponseInterface $response)
    {
        $this->request = $request;
        $this->response = $response;
        $model = $this->getModel();

        $response->getBody()->write($this->getTemplateRenderer()->render($this->getTemplateName(), [
            'model' => $model,
        ]));

        return $response->withHeader('Content-Type', 'text/html');
    }

    abstract public function getModelClass();
    
    abstract public function getTemplateName();

    /**
     * @return object
     */
    protected function getModel()
    {
        return $this->getObjectManager()->getRepository('class')->find($this->request->getAttribute('id'));
    }
}