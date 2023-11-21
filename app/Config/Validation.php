<?php

namespace Config;

use CodeIgniter\Config\BaseConfig;
use CodeIgniter\Validation\StrictRules\CreditCardRules;
use CodeIgniter\Validation\StrictRules\FileRules;
use CodeIgniter\Validation\StrictRules\FormatRules;
use CodeIgniter\Validation\StrictRules\Rules;

class Validation extends BaseConfig
{
    // --------------------------------------------------------------------
    // Setup
    // --------------------------------------------------------------------

    /**
     * Stores the classes that contain the
     * rules that are available.
     *
     * @var string[]
     */
    public array $ruleSets = [
        Rules::class,
        FormatRules::class,
        FileRules::class,
        CreditCardRules::class,
    ];

    /**
     * Specifies the views that are used to display the
     * errors.
     *
     * @var array<string, string>
     */
    public array $templates = [
        'list'   => 'CodeIgniter\Validation\Views\list',
        'single' => 'CodeIgniter\Validation\Views\single',
    ];

    // --------------------------------------------------------------------
    // Rules
    // --------------------------------------------------------------------



   public $librerias = [
    'titulo' => [
        'label' => 'Titulo',
        'rules' => 'required|min_length[3]|max_length[255]',
        'errors' => [
            'required' => 'El campo {field} es obligatorio.',
            'min_length' => 'El campo {field} debe tener al menos {param} caracteres de longitud.',
            'max_length' => 'El campo {field} no puede exceder los {param} caracteres de longitud.',
            
        ],
    ],
    'descripcion' => [
    'label' => 'descripcion',
    'rules' => 'required|min_length[3]|max_length[2000]',
    'errors' => [
        'required' => 'El campo {field} es obligatorio.',
        'min_length' => 'El campo {field} debe tener al menos {param} caracteres de longitud.',
        'max_length' => 'El campo {field} no puede exceder los {param} caracteres de longitud.',
        
    ],
],
    'id_categoria' => [
    'label' => 'categoria',
    'rules' => 'required',
    'errors' => [
        'required' => 'Selecciona una {field} ',
    ],
],
];

   public $usuarios = [
    'usuario' => [
        'label' => 'Usuario',
        'rules' => 'required|min_length[5]|max_length[20]|is_unique[usuarios.usuario,id,{id}]',
        'errors' => [
            'required' => 'El campo {field} es obligatorio.',
            'min_length' => 'El campo {field} debe tener al menos {param} caracteres de longitud.',
            'max_length' => 'El campo {field} no puede exceder los {param} caracteres de longitud.',
            'is_unique' => 'Este {field} ya está registrado.',
        ],
    ],
    'correo' => [
        'label' => 'Correo',
        'rules' => 'valid_email|required|is_unique[usuarios.correo,id,{id}]',
        'errors' => [
            'valid_email' => 'Debe proporcionar una dirección de correo válida.',
            'required' => 'El campo {field} es obligatorio.',
            'is_unique' => 'Este {field} ya está registrado.',
        ],
    ],
    'contrasena' => [
        'label' => 'Contraseña',
        'rules' => 'required|permit_empty|min_length[8]',
        'errors' => [
            'required' => 'El campo {field} es obligatorio.',
            'min_length' => 'El campo {field} debe tener al menos {param} caracteres de longitud.',
        ],
    ],
   ];
   /**
    * Summary of categorias
    * @var array
    */
   public $categorias = [
    'nombre' => [
    'label' => 'categoria',
    'rules' => 'required|min_length[3]|max_length[40]',
    'errors' => [
        'required' => 'El campo {field} es obligatorio.',
        'min_length' => 'El campo {field} debe tener al menos {param} caracteres de longitud.',
        'max_length' => 'El campo {field} no puede exceder los {param} caracteres de longitud.',
        
    ], 
],
    'descripcion'  =>[
    'label' => 'descripcion',
    'rules' => 'required|min_length[3]|max_length[300]',
    'errors' => [
        'required' => 'El campo {field} es obligatorio.',
        'min_length' => 'El campo {field} debe tener al menos {param} caracteres de longitud.',
        'max_length' => 'El campo {field} no puede exceder los {param} caracteres de longitud.',
],
],
];
   public $comentarioReglas =  [ // he quitado que sea requerida la valoración.
    'contenido' => [
        'rules' => 'required|min_length[3]',
        'errors' => [
            'required' => 'El campo contenido es obligatorio.',
            'min_length' => 'El campo contenido debe tener al menos 3 caracteres de longitud.',
        ],
    ],
    
    
];

}