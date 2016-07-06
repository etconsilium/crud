<?php


namespace Eva\Crud;


use Psr\Http\Message\ResponseInterface;
use Psr\Http\Message\ServerRequestInterface;

abstract class AbstractCreateAction extends AbstractAction
{
    public function __invoke(ServerRequestInterface $request, ResponseInterface $response)
    {
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

    public function getModel()
    {
        $className = $this->getModelClass();

        return new $className;
    }
    
    public function afterSave()
    {
        
    }
}