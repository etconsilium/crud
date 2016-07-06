<?php


namespace Eva\Crud;


use Psr\Http\Message\ResponseInterface;
use Psr\Http\Message\ServerRequestInterface;

abstract class UpdateAction extends AbstractAction
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
        $form = $this->getForm();

        $form->bind($model);
        if ($request->getParsedBody() && $form->isValid()) {
            $this->getObjectManager()->persist($model);
            $this->getObjectManager()->flush();
            $this->afterSave();
        }

        $response->getBody()->write($this->getTemplateRenderer()->render($this->getTemplateName(), [
            'model' => $model,
            'form' => $form,
        ]));

        return $response->withHeader('Content-Type', 'text/html');
    }

    abstract public function getModelClass();
    
    abstract public function getForm();
    
    abstract public function getTemplateName();

    /**
     * @return object
     */
    protected function getModel()
    {
        return $this->getObjectManager()->getRepository('class')->find($this->request->getAttribute('id'));
    }

    public function afterSave()
    {
        
    }
}