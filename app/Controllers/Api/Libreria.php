<?php
namespace App\Controllers\Api;
use CodeIgniter\I18n\Time;

use CodeIgniter\RESTful\ResourceController;

class Libreria extends ResourceController{
    protected $modelName = 'App\Models\LibreriaModel';
    protected $format = 'json';

    public function index() 
    
    {

        return $this->respond($this->model->findAll());
        
    }

    public function create() 
    
    {

        if($this->validate('librerias')){
    
            $id = $this->model->insert([
                'titulo' => $this->request->getPost('titulo'),
                'descripcion' => $this->request->getPost('descripcion'),
                'fecha_subida' => Time::now()
                
    
            ]
        );
    }else{
        return $this->respond($this->validator->getErrors(),400);
        
        
    }
return $this->respond($id);




}

public function update($id = null)
{
    if($this->validate('librerias')){


         $this->model->update($id,
        [

            'titulo' => $this->request->getRawInput()['titulo'],
            'descripcion' => $this->request->getRawInput()['descripcion'],

        ]
    
    );
}   else{
    
        return $this->respond($this->validator->getErrors(),400);
    
    
}
        return $this->respond($id);


}
public function show($id = null)
    {
        return $this->respond($this->model->find($id));
    }
    


public function delete($id = null)
    {
        
       
        $this->model->find($id);
        $this->model->delete($id);

        return $this->respond('eliminado');
    }
}









?>