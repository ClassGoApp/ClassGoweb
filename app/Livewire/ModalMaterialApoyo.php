<?php

namespace App\Livewire;

use App\Services\ImagenesService;
use Livewire\Attributes\On;
use Livewire\Component;
use Livewire\Attributes\Validate;
use Livewire\WithFileUploads;
use App\Models\SlotBooking;
use App\Services\AttachmentsService;

class ModalMaterialApoyo extends Component
{

    use WithFileUploads;

    public bool $isOpen = false;

    // Validación: Máximo 5MB (5120 KB) y extensiones específicas
    #[Validate('nullable|file|mimes:pdf,doc,docx,ods,odt,xls,xlsx,jpg,jpeg,png|max:5120')]
    public $archivo=null;

    #[Validate('nullable|string|min:2|max:700')]
    public ?string $descripcion=null;
    
    public $modalUpdArchivo=null;

    public $idFile = null;
    #[On("openModalMaterialApoyo")]
    public function openModal($modalUpdat=null, $idfile=null){
        $this->modalUpdArchivo=$modalUpdat;
        // dd($modalUpdat, $idfile);
        $this->idFile = $idfile;
        $this->isOpen = true;

        $this->reset(['archivo', 'descripcion']);
        $this->resetValidation();
    }
    
    public function updatedArchivo()
    {   
        $this->validateOnly('archivo');
    }


    public function confirmarReserva(ImagenesService $imagenesService, AttachmentsService $attachmentsService)
    {
        // CONDICIÓN: Si el usuario cargó un archivo, la descripción se vuelve obligatoria
        
        if($this->idFile){
            $this->validate(
                [
                    'archivo' => 'nullable|file|mimes:pdf,doc,docx,ods,odt,xls,xlsx,jpg,jpeg,png|max:5120',
                    'descripcion' => 'sometimes|string|min:2|max:500',
                ], [
                    'archivo.file'=> 'Debe subir un archivo',
                    'archivo.mimes'=> 'Se admiten los siguiente formatos: pdf,doc,docx,ods,odt,xls,xlsx,jpg,jpeg,png',
                    "archivo.max" => "El archivo debe pesar maximo 5mb",

                    'descripcion.required' => 'Por favor, escribe una breve descripción para darle contexto al profesor sobre tu archivo.',
                    'descripcion.min' => 'La descripción debe tener al menos 2 caracteres.',

                    ]
            
            );
            $attachmentsService->updateAttachment($this->idFile, $this->archivo, $this->descripcion);

            $this->isOpen = false;
            $this->dispatch("ReservacionConfirmada");
            return;
        
        }elseif ($this->archivo) {
            $this->validate([
                'descripcion' => 'required|string|min:2|max:500',
            ], [
                // Mensaje personalizado amigable
                'descripcion.required' => 'Por favor, escribe una breve descripción para darle contexto al profesor sobre tu archivo.',
                'descripcion.min' => 'La descripción debe tener al menos 2 caracteres.'
            ]);
            // dd($this->archivo, $this->archivo->getRealPath() .'--ñ---');
            
                
                    
            $datosFileProcesado = $imagenesService->guardarMaterialApoyoEstudiante($this->archivo, SlotBooking::class);
            // Si pasa la validación, mandamos el path temporal y la descripción al padre
            $this->dispatch('archivo-agregado', 
                archivo_temporal: $datosFileProcesado,
                description: $this->descripcion
            );
        } 
         else {
            // CONDICIÓN: Si NO hay archivo, mandamos null en ambos campos y pasa normal
            $this->dispatch('archivo-agregado', 
                archivo_temporal: null, 
                description: null
            );
        }

        // Cerramos el modal y disparamos la confirmación final de la reserva
        $this->isOpen = false;   
        $this->dispatch("ReservacionConfirmada");
    }


    public function render()
    {
        return view('livewire.modal-material-apoyo');
    }
}
